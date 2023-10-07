<?php

declare(strict_types=1);

namespace WSBusch\InteramtConnect\Domain\Model;


/**
 * This file is part of the "Interamt Connector" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 Oliver Busch <oliver@busch-oliver.de>, Webservice Busch
 */

/**
 * Vacancy
 */
class Vacancy extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * interamtUid
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $interamtUid = null;

    /**
     * authority
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $authority = null;

    /**
     * @var Authority|null
     */
    protected $authorityObject = null;

    /**
     * identifier
     *
     * @var string
     */
    protected $identifier = null;

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = null;

    /**
     * locationStreet
     *
     * @var string
     */
    protected $locationStreet = null;

    /**
     * locationZip
     *
     * @var string
     */
    protected $locationZip = null;

    /**
     * locationCity
     *
     * @var string
     */
    protected $locationCity = null;

    /**
     * description
     *
     * @var string
     */
    protected $description = null;

    /**
     * latitude
     *
     * @var string
     */
    protected $latitude = null;

    /**
     * longitude
     *
     * @var string
     */
    protected $longitude = null;

    /**
     * numberOfVacancies
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $numberOfVacancies = null;

    /**
     * contracts
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $contracts = null;

    /**
     * careers
     *
     * @var string
     */
    protected $careers = null;

    /**
     * salaryGroupFrom
     *
     * @var string
     */
    protected $salaryGroupFrom = null;

    /**
     * salaryGroupTo
     *
     * @var string
     */
    protected $salaryGroupTo = null;

    /**
     * tariffLevelFrom
     *
     * @var string
     */
    protected $tariffLevelFrom = null;

    /**
     * tariffLevelTo
     *
     * @var string
     */
    protected $tariffLevelTo = null;

    /**
     * qualification
     *
     * @var string
     */
    protected $qualification = null;

    /**
     * training
     *
     * @var string
     */
    protected $training = null;

    /**
     * trainingDuration
     *
     * @var float
     */
    protected $trainingDuration = null;

    /**
     * responsibilities
     *
     * @var string
     */
    protected $responsibilities = null;

    /**
     * subjectArea
     *
     * @var string
     */
    protected $subjectArea = null;

    /**
     * workTime
     *
     * @var string
     */
    protected $workTime = null;

    /**
     * weeklyWorkingTimeCivilServant
     *
     * @var string
     */
    protected $weeklyWorkingTimeCivilServant = null;

    /**
     * weeklyWorkingTimeEmployee
     *
     * @var string
     */
    protected $weeklyWorkingTimeEmployee = null;

    /**
     * durationOfEmployment
     *
     * @var string
     */
    protected $durationOfEmployment = null;

    /**
     * limitedTo
     *
     * @var string
     */
    protected $limitedTo = null;

    /**
     * applicationDeadline
     *
     * @var \DateTime
     */
    protected $applicationDeadline = null;

    /**
     * occupationTo
     *
     * @var string
     */
    protected $occupationTo = null;

    /**
     * lastChanges
     *
     * @var \DateTime
     */
    protected $lastChanges = null;

    /**
     * tenderDate
     *
     * @var \DateTime
     */
    protected $tenderDate = null;

    /**
     * applicationProcess
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $applicationProcess = null;

    /**
     * applicationUrl
     *
     * @var string
     */
    protected $applicationUrl = null;

    /**
     * requiredStudies
     *
     * @var string
     */
    protected $requiredStudies = null;

    /**
     * @var string
     */
    protected $attachments = null;

    /**
     * contactLastname
     *
     * @var string
     */
    protected $contactLastname = null;

    /**
     * contactFirstname
     *
     * @var string
     */
    protected $contactFirstname = null;

    /**
     * contactSalutaion
     *
     * @var string
     */
    protected $contactSalutaion = null;

    /**
     * contactStreet
     *
     * @var string
     */
    protected $contactStreet = null;

    /**
     * contactZip
     *
     * @var string
     */
    protected $contactZip = null;

    /**
     * contactCity
     *
     * @var string
     */
    protected $contactCity = null;

    /**
     * contactAuthority
     *
     * @var string
     */
    protected $contactAuthority = null;

    /**
     * contactPhone
     *
     * @var string
     */
    protected $contactPhone = null;

    /**
     * contactMobile
     *
     * @var string
     */
    protected $contactMobile = null;

    /**
     * contactFax
     *
     * @var string
     */
    protected $contactFax = null;

    /**
     * contactEmail
     *
     * @var string
     */
    protected $contactEmail = null;

    /**
     * @var string
     */
    protected $besoldung = '';

    /**
     * Returns the interamtUid
     *
     * @return int
     */
    public function getInteramtUid()
    {
        return $this->interamtUid;
    }

    /**
     * Sets the interamtUid
     *
     * @param string $interamtUid
     * @return void
     */
    public function setInteramtUid(int $interamtUid)
    {
        $this->interamtUid = $interamtUid;
    }

    /**
     * Returns the authority
     *
     * @return int
     */
    public function getAuthority()
    {
        return $this->authority;
    }

    /**
     * Sets the authority
     *
     * @param int $authority
     * @return void
     */
    public function setAuthority(int $authority)
    {
        $this->authority = $authority;
    }

    /**
     * Returns the identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Sets the identifier
     *
     * @param string $identifier
     * @return void
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Returns the locationStreet
     *
     * @return string
     */
    public function getLocationStreet()
    {
        return $this->locationStreet;
    }

    /**
     * Sets the locationStreet
     *
     * @param string $locationStreet
     * @return void
     */
    public function setLocationStreet(string $locationStreet)
    {
        $this->locationStreet = $locationStreet;
    }

    /**
     * Returns the locationZip
     *
     * @return string
     */
    public function getLocationZip()
    {
        return $this->locationZip;
    }

    /**
     * Sets the locationZip
     *
     * @param string $locationZip
     * @return void
     */
    public function setLocationZip(string $locationZip)
    {
        $this->locationZip = $locationZip;
    }

    /**
     * Returns the locationCity
     *
     * @return string
     */
    public function getLocationCity()
    {
        return $this->locationCity;
    }

    /**
     * Sets the locationCity
     *
     * @param string $locationCity
     * @return void
     */
    public function setLocationCity(string $locationCity)
    {
        $this->locationCity = $locationCity;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Returns the latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param string $latitude
     * @return void
     */
    public function setLatitude(string $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param string $longitude
     * @return void
     */
    public function setLongitude(string $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the numberOfVacancies
     *
     * @return int
     */
    public function getNumberOfVacancies()
    {
        return $this->numberOfVacancies;
    }

    /**
     * Sets the numberOfVacancies
     *
     * @param int $numberOfVacancies
     * @return void
     */
    public function setNumberOfVacancies(int $numberOfVacancies)
    {
        $this->numberOfVacancies = $numberOfVacancies;
    }

    /**
     * Returns the contracts
     *
     * @return string
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    /**
     * Sets the contracts
     *
     * @param string $contracts
     * @return void
     */
    public function setContracts(string $contracts)
    {
        $this->contracts = $contracts;
    }

    /**
     * Returns the careers
     *
     * @return string
     */
    public function getCareers()
    {
        return $this->careers;
    }

    /**
     * Sets the careers
     *
     * @param string $careers
     * @return void
     */
    public function setCareers(string $careers)
    {
        $this->careers = $careers;
    }

    /**
     * Returns the salaryGroupFrom
     *
     * @return string
     */
    public function getSalaryGroupFrom()
    {
        return $this->salaryGroupFrom;
    }

    /**
     * Sets the salaryGroupFrom
     *
     * @param string $salaryGroupFrom
     * @return void
     */
    public function setSalaryGroupFrom(string $salaryGroupFrom)
    {
        $this->salaryGroupFrom = $salaryGroupFrom;
    }

    /**
     * Returns the salaryGroupTo
     *
     * @return string
     */
    public function getSalaryGroupTo()
    {
        return $this->salaryGroupTo;
    }

    /**
     * Sets the salaryGroupTo
     *
     * @param string $salaryGroupTo
     * @return void
     */
    public function setSalaryGroupTo(string $salaryGroupTo)
    {
        $this->salaryGroupTo = $salaryGroupTo;
    }

    /**
     * Returns the tariffLevelFrom
     *
     * @return string
     */
    public function getTariffLevelFrom()
    {
        return $this->tariffLevelFrom;
    }

    /**
     * Sets the tariffLevelFrom
     *
     * @param string $tariffLevelFrom
     * @return void
     */
    public function setTariffLevelFrom(string $tariffLevelFrom)
    {
        $this->tariffLevelFrom = $tariffLevelFrom;
    }

    /**
     * Returns the tariffLevelTo
     *
     * @return string
     */
    public function getTariffLevelTo()
    {
        return $this->tariffLevelTo;
    }

    /**
     * Sets the tariffLevelTo
     *
     * @param string $tariffLevelTo
     * @return void
     */
    public function setTariffLevelTo(string $tariffLevelTo)
    {
        $this->tariffLevelTo = $tariffLevelTo;
    }

    /**
     * Returns the qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Sets the qualification
     *
     * @param string $qualification
     * @return void
     */
    public function setQualification(string $qualification)
    {
        $this->qualification = $qualification;
    }

    /**
     * Returns the training
     *
     * @return string
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * Sets the training
     *
     * @param string $training
     * @return void
     */
    public function setTraining(string $training)
    {
        $this->training = $training;
    }

    /**
     * Returns the trainingDuration
     *
     * @return float
     */
    public function getTrainingDuration()
    {
        return $this->trainingDuration;
    }

    /**
     * Sets the trainingDuration
     *
     * @param float|int $trainingDuration
     * @return void
     */
    public function setTrainingDuration($trainingDuration)
    {
        $this->trainingDuration = $trainingDuration;
    }

    /**
     * Returns the responsibilities
     *
     * @return string
     */
    public function getResponsibilities()
    {
        return $this->responsibilities;
    }

    /**
     * Sets the responsibilities
     *
     * @param string $responsibilities
     * @return void
     */
    public function setResponsibilities(string $responsibilities)
    {
        $this->responsibilities = $responsibilities;
    }

    /**
     * Returns the subjectArea
     *
     * @return string
     */
    public function getSubjectArea()
    {
        return $this->subjectArea;
    }

    /**
     * Sets the subjectArea
     *
     * @param string $subjectArea
     * @return void
     */
    public function setSubjectArea(string $subjectArea)
    {
        $this->subjectArea = $subjectArea;
    }

    /**
     * Returns the workTime
     *
     * @return string
     */
    public function getWorkTime()
    {
        return $this->workTime;
    }

    /**
     * Sets the workTime
     *
     * @param string $workTime
     * @return void
     */
    public function setWorkTime(string $workTime)
    {
        $this->workTime = $workTime;
    }

    /**
     * Returns the weeklyWorkingTimeCivilServant
     *
     * @return string
     */
    public function getWeeklyWorkingTimeCivilServant()
    {
        return $this->weeklyWorkingTimeCivilServant;
    }

    /**
     * Sets the weeklyWorkingTimeCivilServant
     *
     * @param string $weeklyWorkingTimeCivilServant
     * @return void
     */
    public function setWeeklyWorkingTimeCivilServant(string $weeklyWorkingTimeCivilServant)
    {
        $this->weeklyWorkingTimeCivilServant = $weeklyWorkingTimeCivilServant;
    }

    /**
     * Returns the weeklyWorkingTimeEmployee
     *
     * @return string
     */
    public function getWeeklyWorkingTimeEmployee()
    {
        return $this->weeklyWorkingTimeEmployee;
    }

    /**
     * Sets the weeklyWorkingTimeEmployee
     *
     * @param string $weeklyWorkingTimeEmployee
     * @return void
     */
    public function setWeeklyWorkingTimeEmployee(string $weeklyWorkingTimeEmployee)
    {
        $this->weeklyWorkingTimeEmployee = $weeklyWorkingTimeEmployee;
    }

    /**
     * Returns the durationOfEmployment
     *
     * @return string
     */
    public function getDurationOfEmployment()
    {
        return $this->durationOfEmployment;
    }

    /**
     * Sets the durationOfEmployment
     *
     * @param string $durationOfEmployment
     * @return void
     */
    public function setDurationOfEmployment(string $durationOfEmployment)
    {
        $this->durationOfEmployment = $durationOfEmployment;
    }

    /**
     * Returns the limitedTo
     *
     * @return string
     */
    public function getLimitedTo()
    {
        return $this->limitedTo;
    }

    /**
     * Sets the limitedTo
     *
     * @param string $limitedTo
     * @return void
     */
    public function setLimitedTo(string $limitedTo)
    {
        $this->limitedTo = $limitedTo;
    }

    /**
     * Returns the applicationDeadline
     *
     * @return \DateTime|null
     */
    public function getApplicationDeadline()
    {
        return $this->applicationDeadline;
    }

    /**
     * Sets the applicationDeadline
     *
     * @param \DateTime|null $applicationDeadline
     * @return void
     */
    public function setApplicationDeadline(?\DateTime $applicationDeadline)
    {
        $this->applicationDeadline = $applicationDeadline;
    }

    /**
     * Returns the occupationTo
     *
     * @return string
     */
    public function getOccupationTo()
    {
        return $this->occupationTo;
    }

    /**
     * Sets the occupationTo
     *
     * @param string $occupationTo
     * @return void
     */
    public function setOccupationTo(string $occupationTo)
    {
        $this->occupationTo = $occupationTo;
    }

    /**
     * Returns the lastChanges
     *
     * @return \DateTime|null
     */
    public function getLastChanges()
    {
        return $this->lastChanges;
    }

    /**
     * Sets the lastChanges
     *
     * @param \DateTime|null $lastChanges
     * @return void
     */
    public function setLastChanges(?\DateTime $lastChanges)
    {
        $this->lastChanges = $lastChanges;
    }

    /**
     * Returns the tenderDate
     *
     * @return \DateTime|null
     */
    public function getTenderDate()
    {
        return $this->tenderDate;
    }

    /**
     * Sets the tenderDate
     *
     * @param \DateTime|null $tenderDate
     * @return void
     */
    public function setTenderDate(?\DateTime $tenderDate)
    {
        $this->tenderDate = $tenderDate;
    }

    /**
     * Returns the applicationProcess
     *
     * @return string
     */
    public function getApplicationProcess()
    {
        return $this->applicationProcess;
    }

    /**
     * Sets the applicationProcess
     *
     * @param string $applicationProcess
     * @return void
     */
    public function setApplicationProcess(string $applicationProcess)
    {
        $this->applicationProcess = $applicationProcess;
    }

    /**
     * Returns the applicationUrl
     *
     * @return string
     */
    public function getApplicationUrl()
    {
        return $this->applicationUrl;
    }

    /**
     * Sets the applicationUrl
     *
     * @param string $applicationUrl
     * @return void
     */
    public function setApplicationUrl(string $applicationUrl)
    {
        $this->applicationUrl = $applicationUrl;
    }

    /**
     * Returns the requiredStudies
     *
     * @return string
     */
    public function getRequiredStudies()
    {
        return $this->requiredStudies;
    }

    /**
     * Sets the requiredStudies
     *
     * @param string $requiredStudies
     * @return void
     */
    public function setRequiredStudies(string $requiredStudies)
    {
        $this->requiredStudies = $requiredStudies;
    }

    /**
     * @return string
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param string $attachments
     * @return void
     */
    public function setAttachments(string $attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * Returns the contactLastname
     *
     * @return string
     */
    public function getContactLastname()
    {
        return $this->contactLastname;
    }

    /**
     * Sets the contactLastname
     *
     * @param string $contactLastname
     * @return void
     */
    public function setContactLastname(string $contactLastname)
    {
        $this->contactLastname = $contactLastname;
    }

    /**
     * Returns the contactFirstname
     *
     * @return string
     */
    public function getContactFirstname()
    {
        return $this->contactFirstname;
    }

    /**
     * Sets the contactFirstname
     *
     * @param string $contactFirstname
     * @return void
     */
    public function setContactFirstname(string $contactFirstname)
    {
        $this->contactFirstname = $contactFirstname;
    }

    /**
     * Returns the contactSalutaion
     *
     * @return string
     */
    public function getContactSalutaion()
    {
        return $this->contactSalutaion;
    }

    /**
     * Sets the contactSalutaion
     *
     * @param string $contactSalutaion
     * @return void
     */
    public function setContactSalutaion(string $contactSalutaion)
    {
        $this->contactSalutaion = $contactSalutaion;
    }

    /**
     * Returns the contactStreet
     *
     * @return string
     */
    public function getContactStreet()
    {
        return $this->contactStreet;
    }

    /**
     * Sets the contactStreet
     *
     * @param string $contactStreet
     * @return void
     */
    public function setContactStreet(string $contactStreet)
    {
        $this->contactStreet = $contactStreet;
    }

    /**
     * Returns the contactZip
     *
     * @return string
     */
    public function getContactZip()
    {
        return $this->contactZip;
    }

    /**
     * Sets the contactZip
     *
     * @param string $contactZip
     * @return void
     */
    public function setContactZip(string $contactZip)
    {
        $this->contactZip = $contactZip;
    }

    /**
     * Returns the contactCity
     *
     * @return string
     */
    public function getContactCity()
    {
        return $this->contactCity;
    }

    /**
     * Sets the contactCity
     *
     * @param string $contactCity
     * @return void
     */
    public function setContactCity(string $contactCity)
    {
        $this->contactCity = $contactCity;
    }

    /**
     * Returns the contactAuthority
     *
     * @return string
     */
    public function getContactAuthority()
    {
        return $this->contactAuthority;
    }

    /**
     * Sets the contactAuthority
     *
     * @param string $contactAuthority
     * @return void
     */
    public function setContactAuthority(string $contactAuthority)
    {
        $this->contactAuthority = $contactAuthority;
    }

    /**
     * Returns the contactPhone
     *
     * @return string
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * Sets the contactPhone
     *
     * @param string $contactPhone
     * @return void
     */
    public function setContactPhone(string $contactPhone)
    {
        $this->contactPhone = $contactPhone;
    }

    /**
     * Returns the contactMobile
     *
     * @return string
     */
    public function getContactMobile()
    {
        return $this->contactMobile;
    }

    /**
     * Sets the contactMobile
     *
     * @param string $contactMobile
     * @return void
     */
    public function setContactMobile(string $contactMobile)
    {
        $this->contactMobile = $contactMobile;
    }

    /**
     * Returns the contactFax
     *
     * @return string
     */
    public function getContactFax()
    {
        return $this->contactFax;
    }

    /**
     * Sets the contactFax
     *
     * @param string $contactFax
     * @return void
     */
    public function setContactFax(string $contactFax)
    {
        $this->contactFax = $contactFax;
    }

    /**
     * Returns the contactEmail
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Sets the contactEmail
     *
     * @param string $contactEmail
     * @return void
     */
    public function setContactEmail(string $contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return void
     */
    public function setBesoldung(): void
    {
        $besoldung = '';
        $groupFrom = $this->getSalaryGroupFrom();
        $groupTo = $this->getSalaryGroupTo();
        $levelFrom = $this->getTariffLevelFrom();
        $levelTo = $this->getTariffLevelTo();

        if($groupFrom !== '') {
            $besoldung .= $groupFrom;
            if($groupTo !== '' && $groupTo !== $groupFrom) {
                $besoldung .= ' - '.$groupTo;
            }
        }

        if($levelFrom !== '') {
            if($besoldung !== '') {
                $besoldung .= ' / ';
            }
            $besoldung .= $levelFrom;
            if($levelTo !== '' && $levelTo !== $levelFrom) {
                $besoldung .= ' - '.$levelTo;
            }
        }

        $this->besoldung = $besoldung;
    }

    /**
     * @return string
     */
    public function getBesoldung(): string
    {
        return $this->besoldung;
    }

    /**
     * @return Authority|null
     */
    public function getAuthorityObject(): ?Authority
    {
        return $this->authorityObject;
    }

    /**
     * @param Authority|null $authorityObject
     * @return void
     */
    public function setAuthorityObject(?Authority $authorityObject): void {
        $this->authorityObject = $authorityObject;
    }
}
