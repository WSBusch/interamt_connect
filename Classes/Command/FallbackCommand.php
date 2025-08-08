<?php

namespace WSBusch\InteramtConnect\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use WSBusch\InteramtConnect\Domain\Model\Authority;
use WSBusch\InteramtConnect\Domain\Model\Vacancy;
use WSBusch\InteramtConnect\Domain\Repository\AuthorityRepository;
use WSBusch\InteramtConnect\Domain\Repository\VacancyRepository;
use WSBusch\InteramtConnect\Services\ConnectorService;

class FallbackCommand extends Command
{
    /**
     * @var ConfigurationManagerInterface
     */
    protected ConfigurationManagerInterface $configurationManager;

    /**
     * @var VacancyRepository
     */
    protected VacancyRepository $vacancyRepository;

    /**
     * TS settings
     * @var array
     */
    protected array $settings=[];

    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setDescription('Loads all current job offers to defined authorities via an INTERAMT interface and stores the jobs as fallback in the database.');
        $this->setHelp('Loads INTERAMT job offers.');
    }

    /**
     * Executes the command for showing sys_log entries
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->loadSettings();
        $this->vacancyRepository = GeneralUtility::makeInstance(VacancyRepository::class);
        if($this->settings['useConnectorFallback'] === 1) {
            $authorities = $this->loadAuthorities();
            if(\count($authorities) > 0) {
                $connectorService = GeneralUtility::makeInstance(ConnectorService::class);
                $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
                if($connectorService->serviceIsOnline($this->settings)) {
                    $todaysImportHash = bin2hex(random_bytes(15));
                    foreach($authorities as $authority) {
                        $authorityUid = $authority['uid'];
                        $authorityInteramtUid = $authority['interamt_uid'];
                        $authorityPid = $authority['storage_pid'];
                        $demand = [];
                        $demand['authority'] = $authorityInteramtUid;
                        $demand['usePagination'] = false;
                        $vacancies = $connectorService->collectVacanciesListByDemand($this->settings, $demand);

                        $this->removeDeleted($authorityUid);

                        if(\count($vacancies) > 0) {
                            foreach($vacancies as $vacancyInput) {
                                $existingRecord = $this->vacancyRepository->findByInteramtUid((int) $vacancyInput['Id']);
                                $writeRecord = true;
                                if($existingRecord) {
                                    if($this->settings['connectorExistingRecords'] === 'ignore') {
                                        $writeRecord = false;
                                    } else {
                                        $this->vacancyRepository->remove($existingRecord);
                                        $persistenceManager->persistAll();
                                    }
                                }

                                if($writeRecord) {
                                    $job = $connectorService->collectVacancyByUid($this->settings,
                                        (int)$vacancyInput['Id']);
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
                                    $vacancy->setPid($authorityPid);
                                    $vacancy->setAuthority($authorityUid);
                                    $vacancy->setInteramtUid((int)$job['Id']);
                                    $vacancy->setIdentifier($job['Kennung']);
                                    $vacancy->setDescription($job['Beschreibung']);
                                    $vacancy->setTitle($job['Stellenbezeichnung']);
                                    if (is_array($job['Einsatzort'])) {
                                        $vacancy->setLocationStreet($job['Einsatzort']['EinsatzortStrasse'] ?? '');
                                        $vacancy->setLocationZip($job['Einsatzort']['EinsatzortPLZ'] ?? '');
                                        $vacancy->setLocationCity($job['Einsatzort']['EinsatzortOrt'] ?? '');
                                    }
                                    $vacancy->setLatitude($job['Breite']);
                                    $vacancy->setLongitude($job['Laenge']);
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
                                    $vacancy->setImportHash($todaysImportHash);
                                    $this->vacancyRepository->add($vacancy);
                                }
                            }
                            $persistenceManager->persistAll();
                        }
                    }

                    // remove all vacancies with different import-hash
                    $vacanciesToRemove = $this->vacancyRepository->findAllWithDifferentImportHash($todaysImportHash);
                    if($vacanciesToRemove) {
                        foreach($vacanciesToRemove as $vacancyToRemove) {
                            $this->vacancyRepository->remove($vacancyToRemove);
                        }
                        $persistenceManager->persistAll();
                    }
                }
            }
        }
        return 0;
    }

    private function loadSettings(): void {
        $settings = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['interamt_connect'];
        $this->settings = [
            'useConnectorFallback' => (int) $settings['connectorUseFallback'],
            'connectorUrl' => trim($settings['connectorUrl']),
            'connectorService' => trim($settings['connectorService']),
            'connectorExistingRecords' => trim($settings['connectorExistingRecords']),
            'proxyEnable' => (int) $settings['proxyEnable'],
            'proxySchema' => trim($settings['proxySchema']),
            'proxyServer' => trim($settings['proxyServer']),
            'proxyPort' => (int) $settings['proxyPort']
        ];
    }

    private function loadAuthorities(): array {
        $repo = GeneralUtility::makeInstance(AuthorityRepository::class);
        $authorities = $repo->findAllForTask();
        $items = [];
        foreach($authorities as $authority) {
            /** @var Authority $authority */
            $items[] = [
                'uid' => $authority->getUid(),
                'interamt_uid' => $authority->getinteramtUid(),
                'storage_pid' => $authority->getStorageUid()
            ];
        }
        return $items;
    }

    private function removeDeleted($authority=0) {
        $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
        $table = 'tx_interamtconnect_domain_model_vacancy';
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable($table);
        if($authority > 0) {
            $queryBuilder
                ->delete($table)
                ->where(
                    $queryBuilder->expr()->eq('deleted',1),
                    $queryBuilder->expr()->eq('authority', $authority)
                );
        } else {
            $queryBuilder
                ->delete($table)
                ->where(
                    $queryBuilder->expr()->eq('deleted',1)
                );
        }
        if($versionInformation->getMajorVersion() < 13) {
            $queryBuilder->execute();
        } else {
            $queryBuilder->executeQuery();
        }

    }
}