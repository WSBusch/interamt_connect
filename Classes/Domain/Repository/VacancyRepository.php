<?php

declare(strict_types=1);

namespace WSBusch\InteramtConnect\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use WSBusch\InteramtConnect\Domain\Model\Authority;
use WSBusch\InteramtConnect\Domain\Model\Vacancy;

/**
 * This file is part of the "Interamt Connector" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 Oliver Busch <oliver@busch-oliver.de>, Webservice Busch
 */

/**
 * The repository for Vacancies
 */
class VacancyRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findByInteramtUid($interamtUid) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('interamt_uid', $interamtUid));
        return $query->execute()->getFirst();
    }

    public function findAllByDemand(array $demand=[]) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $query->setOrderings(
            [
                $demand['sort']['field'] => (strtoupper($demand['sort']['dir']) === 'ASC' ?
                    QueryInterface::ORDER_ASCENDING : QueryInterface::ORDER_DESCENDING)
            ]
        );

        $constraints = [];
        $constraints[] = $query->greaterThan('uid', 0);
        $constraints[] = $query->greaterThanOrEqual('pid', 0);

        $authorityConstraints = [];
        foreach($demand['authorities'] as $authority) {
            /**
             * @var Authority $authority
             */
            $authoritySubConstraint = [];
            $authoritySubConstraint[] = $query->equals('authority', $authority->getUid());
            $authoritySubConstraint[] = $query->equals('pid', $authority->getStorageUid());
            $authorityConstraints[] = $query->logicalAnd(...$authoritySubConstraint);
        }

        if(\count($authorityConstraints) > 0) {
            if(\count($authorityConstraints) === 1) {
                $constraints[] = reset($authorityConstraints);
            } else {
                $constraints[] = $query->logicalOr(...$authorityConstraints);
            }
        }

        if($demand['filter']) {
            $filter = $demand['filter'];
            if($filter['free_text']) {
                if(is_array($filter['free_text']) && \count($filter['free_text']) > 0) {
                    $searchConstraints = [];
                    $searchFields = ['title','location_street','description','tariff_level_from','tariff_level_to'];
                    foreach($filter['free_text'] as $searchString) {
                        $stringConstraints = [];
                        foreach($searchFields as $searchField) {
                            $stringConstraints[] = $query->like($searchField, '%'.$searchString.'%');
                        }
                        $searchConstraints[] = $query->logicalOr(...$stringConstraints);
                    }
                    $constraints[] = $query->logicalAnd(...$searchConstraints);
                }
            }

            if($filter['contracts']) {
                if(is_array($filter['contracts']) && \count($filter['contracts']) > 0) {
                    $contractsConstraints = [];
                    foreach($filter['contracts'] as $contract) {
                        $contractValue = $contract[0];
                        $contractsConstraints[] = $query->like('contracts', '%'.$contractValue.'%');
                    }
                    if(\count($contractsConstraints) === 1) {
                        $constraints[] = reset($contractsConstraints);
                    } else {
                        $constraints[] = $query->logicalOr(...$contractsConstraints);
                    }
                }
            }

            if($filter['areas']) {
                if(is_array($filter['areas']) && \count($filter['areas']) > 0) {
                    $areaConstraints = [];
                    foreach($filter['areas'] as $area) {
                        $areaValue = $area[0];
                        $areaConstraints[] = $query->like('responsibilities', '%'.$areaValue.'%');
                    }
                    if(\count($areaConstraints) === 1) {
                        $constraints[] = reset($areaConstraints);
                    } else {
                        $constraints[] = $query->logicalOr(...$areaConstraints);
                    }
                }
            }

            if($filter['duration']) {
                $durationValue = $filter['duration'][0];
                if($durationValue !== '') {
                    $constraints[] = $query->equals('duration_of_employment', $durationValue);
                }
            }

            if($filter['workTime']) {
                $workTimeValue = $filter['workTime'][0];
                if($workTimeValue !== '') {
                    if($filter['workTime'][1] !== 3) {
                        $wtConstraints = [];
                        $wtConstraints[] = $query->equals('work_time', $workTimeValue);
                        $wtConstraints[] = $query->equals('work_time', 'beides möglich');
                        $constraints[] = $query->logicalOr(...$wtConstraints);
                    }
                }
            }
        }
        $query->matching($query->logicalAnd(...$constraints));

        return $query->execute();
    }

    public function expandVacancies($vacancies, array $authorities) {
        $authList = $this->authoritiesToKeyArray($authorities);
        foreach($vacancies as $vacancy) {
            /** @var Vacancy $vacancy */
            $authorityObject = $authList[$vacancy->getAuthority()];
            $vacancy->setAuthorityObject($authorityObject);
            $detailLinkParam = $vacancy->getInteramtUid();
            $vacancy->setDetailLinkParam((string)$detailLinkParam);
        }
        return $vacancies;
    }

    public function buildContactPerson(Vacancy $vacancy): array {
        $contact = [];
        $name = '';
        if($vacancy->getContactSalutaion() !== '') {
            $name .= $vacancy->getContactSalutaion().' ';
        }
        if($vacancy->getContactFirstname() !== '') {
            $name .= $vacancy->getContactFirstname().' ';
        }
        if($vacancy->getContactLastname() !== '') {
            $name .= $vacancy->getContactLastname();
        }
        $contact['name'] = $name;
        $contact['company'] = $vacancy->getContactAuthority();
        $contact['email'] = $vacancy->getContactEmail();
        $contact['phone'] = $vacancy->getContactPhone();
        $contact['fax'] = $vacancy->getContactFax();
        $contact['street'] = $vacancy->getContactStreet();
        $contact['zip'] = $vacancy->getContactZip();
        $contact['city'] = $vacancy->getContactCity();

        return $contact;
    }

    public function buildVacancyModelFromConnector(array $job, Authority $authority, array $settings) {
        $dienstverhaeltnisse = implode(', ', $job['Dienstverhaeltnisse']);

        $lastChange = null;
        if ($job['DatumLetzteAenderung']) {
            $lastChange = new \DateTime();
            $lastChange->setTimezone(new \DateTimeZone('Europe/Berlin'));
            $lastChange->setTimestamp(strtotime($job['DatumLetzteAenderung']));
        }

        $publication = null;
        if ($job['DatumOeffentlichAusschreiben']) {
            $publication = new \DateTime();
            $publication->setTimezone(new \DateTimeZone('Europe/Berlin'));
            $publication->setTimestamp(strtotime($job['DatumOeffentlichAusschreiben']));
        }

        $deadline = null;
        if ($job['DatumBewerbungsfrist']) {
            $deadline = new \DateTime();
            $deadline->setTimezone(new \DateTimeZone('Europe/Berlin'));
            $deadlineTimestamp = (int) strtotime($job['DatumBewerbungsfrist']);
            if($deadlineTimestamp > 0) {
                $deadline->setTimestamp($deadlineTimestamp);
            } else {
                $deadline = null;
            }
        }

        $studies = '';
        if ($job['Studiengaenge'] && \count($job['Studiengaenge']) > 0) {
            $studies = serialize($job['Studiengaenge']);
        }

        $attachments = '';
        if ($job['Pflichtanlagen'] && \count($job['Pflichtanlagen']) > 0) {
            $attachments = serialize($job['Pflichtanlagen']);
        }

        $vacancy = new Vacancy();
        $vacancy->setAuthority($authority->getUid());
        $vacancy->setAuthorityObject($authority);
        $vacancy->setInteramtUid((int)$job['Id']);
        $vacancy->setIdentifier($job['Kennung']);
        $vacancy->setDescription($job['Beschreibung']);
        $vacancy->setTitle($job['Stellenbezeichnung']);
        if (is_array($job['Einsatzort'])) {
            $vacancy->setLocationStreet($job['Einsatzort']['EinsatzortStrasse'] ?? '');
            $vacancy->setLocationZip($job['Einsatzort']['EinsatzortPLZ'] ?? '');
            $vacancy->setLocationCity($job['Einsatzort']['EinsatzortOrt'] ?? '');
        }
        $vacancy->setLatitude((string)$job['Breite']);
        $vacancy->setLongitude((string)$job['Laenge']);
        $vacancy->setContracts($dienstverhaeltnisse);
        $vacancy->setNumberOfVacancies((int)$job['AnzahlStellen']);
        $vacancy->setCareers($job['LaufbahnGruppe']);
        $vacancy->setSalaryGroupFrom($job['BesoldungGruppeVon']);
        $vacancy->setSalaryGroupTo($job['BesoldungGruppeBis']);
        $vacancy->setTariffLevelFrom($job['TarifEbeneVon']);
        $vacancy->setTariffLevelTo($job['TarifEbeneBis']);
        $vacancy->setQualification($job['Qualifikation']);
        $vacancy->setTraining($job['Ausbildung']);
        $vacancy->setTrainingDuration($job['Ausbildungsdauer']);
        $vacancy->setResponsibilities($job['Aufgabenbereiche']);
        $vacancy->setSubjectArea($job['Fachrichtung']);
        $vacancy->setWorkTime($job['Teilzeit']);
        $vacancy->setWeeklyWorkingTimeCivilServant($job['WochenarbeitszeitBeamter']);
        $vacancy->setWeeklyWorkingTimeEmployee($job['WochenarbeitszeitArbeitnehmer']);
        $vacancy->setDurationOfEmployment($job['BeschaeftigungDauer']);
        $vacancy->setLimitedTo($job['BefristetFuer']);
        $vacancy->setOccupationTo($job['DatumBesetzungZum']);
        $vacancy->setApplicationProcess($job['ProzessBewerbung']);
        $vacancy->setApplicationUrl($job['BewerbungUrl']);
        $vacancy->setLastChanges($lastChange);
        $vacancy->setTenderDate($publication);
        $vacancy->setApplicationDeadline($deadline);
        if (is_array($job['ExtAnsprechpartner'])) {
            $vacancy->setContactLastname($job['ExtAnsprechpartner']['ExtAnsprechpartnerNachname']);
            $vacancy->setContactFirstname($job['ExtAnsprechpartner']['ExtAnsprechpartnerVorname']);
            $vacancy->setContactPhone($job['ExtAnsprechpartner']['ExtAnsprechpartnerTelefon']);
            $vacancy->setContactMobile($job['ExtAnsprechpartner']['ExtAnsprechpartnerMobil']);
            $vacancy->setContactFax($job['ExtAnsprechpartner']['ExtAnsprechpartnerTelefax']);
            $vacancy->setContactEmail($job['ExtAnsprechpartner']['ExtAnsprechpartnerEMail']);
            $vacancy->setContactSalutaion($job['ExtAnsprechpartner']['ExtAnsprechpartnerAnrede']);
            $vacancy->setContactStreet($job['ExtAnsprechpartner']['ExtAnsprechpartnerStrasse']);
            $vacancy->setContactZip($job['ExtAnsprechpartner']['ExtAnsprechpartnerPLZ']);
            $vacancy->setContactCity($job['ExtAnsprechpartner']['ExtAnsprechpartnerOrt']);
            $vacancy->setContactAuthority($job['ExtAnsprechpartner']['ExtAnsprechpartnerBehoerde']);
        }
        $vacancy->setRequiredStudies($studies);
        $vacancy->setAttachments($attachments);
        return $vacancy;
    }

    /**
     * @param array $authorities
     * @return array
     */
    private function authoritiesToKeyArray(array $authorities): array {
        $list = [];
        foreach($authorities as $authority) {
            $uid = $authority->getUid();
            $list[$uid] = $authority;
        }
        return $list;
    }
}
