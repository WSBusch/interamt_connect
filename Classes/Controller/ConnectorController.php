<?php
declare(strict_types=1);

namespace WSBusch\InteramtConnect\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use WSBusch\InteramtConnect\Domain\Model\Authority;
use WSBusch\InteramtConnect\Domain\Model\Vacancy;
use WSBusch\InteramtConnect\Domain\Repository\AuthorityRepository;
use WSBusch\InteramtConnect\Domain\Repository\VacancyRepository;
use WSBusch\InteramtConnect\Helper\SearchHelper;
use WSBusch\InteramtConnect\Provider\PageTitleProvider;
use WSBusch\InteramtConnect\Services\ConfigurationService;
use WSBusch\InteramtConnect\Services\ConnectorService;

/**
 * This file is part of the "Interamt Connector" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 Oliver Busch <oliver@busch-oliver.de>, Webservice Busch
 */

/**
 * VacancyController
 */
class ConnectorController extends ActionController
{

    /**
     * vacancyRepository
     *
     * @var VacancyRepository
     */
    protected $vacancyRepository = null;

    /**
     * @var AuthorityRepository
     */
    protected $authorityRepository = null;

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @var array
     */
    protected array $searchContracts = [];
    /**
     * @var array
     */
    protected array $searchArea = [];
    /**
     * @var array
     */
    protected array $searchDuration = [];
    /**
     * @var array
     */
    protected array $searchWorkTime = [];

    /**
     * @var array
     */
    protected array $searchHash = [];

    public function __construct(
        private readonly PageTitleProvider $titleProvider
    ) {}

    /**
     * @param VacancyRepository $vacancyRepository
     */
    public function injectVacancyRepository(VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function injectAuthorityRepository(AuthorityRepository $authorityRepository) {
        $this->authorityRepository = $authorityRepository;
    }

    public function initializeAction()
    {
        $this->settings = ConfigurationService::parseSettings($this->settings);

        if($this->settings['filter']['enabled']) {
            $filter = $this->settings['filter'];
            if($this->request->hasArgument('sh')) {
                $this->searchHash = json_decode(hex2bin($this->request->getArgument('sh')), true);
            }
            if($filter['contracts']) {
                $this->searchContracts = SearchHelper::collectContracts($this->searchHash['c'] ?? [], $this->settings);
            }
            if($filter['employment_duration']) {
                $this->searchDuration = SearchHelper::collectEmploymentDuration($this->searchHash['d'] ?? 0,
                    $this->settings);
            }
            if($filter['work_time']) {
                $this->searchWorkTime = SearchHelper::collectWorkTime($this->searchHash['w'] ?? 0, $this->settings);
            }
            if($filter['area']) {
                $this->searchArea = SearchHelper::collectAreas($this->searchHash['a'] ?? [], $this->settings);
            }
        }
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        if($this->settings['mode'] === 'show') {
            $vacancy = (int) $this->request->getArgument('vacancy');
            return (new ForwardResponse('show'))
                ->withArguments(['vacancy' => $vacancy]);
        }

        $demand = [];
        $demand['sort']['field'] = $this->settings['sortField'];
        $demand['sort']['dir'] = $this->settings['sortDirection'];
        $demand['authorities'] = $this->settings['authorities'];
        $demand['filter'] = null;

        $buildFilerSettings = $this->collectActiveFilters($demand);
        $demand = $buildFilerSettings['demand'];
        $activeFilters = $buildFilerSettings['activeFilters'];

        $vacancies = [];
        if(\count($this->settings['authorities']) > 0) {
            $connectorService = GeneralUtility::makeInstance(ConnectorService::class);
            if($this->settings['behaviour'] === 'onFly' && $connectorService->serviceIsOnline($this->settings['extension'])) {
                /* get dataset live from api */
                foreach($this->settings['authorities'] as $odAuthority) {
                    /** @var Authority $odAuthority */
                    $onDemand = [];
                    $onDemand['authority'] = $odAuthority->getinteramtUid();
                    $onDemand['usePagination'] = false;
                    $odVacancies = $connectorService->collectVacanciesListByDemand($this->settings['extension'],
                        $onDemand);
                    if($odVacancies) {
                        foreach($odVacancies as $odVacancy) {
                            /** @var Vacancy $newVacancy */
                            $newVacancy = GeneralUtility::makeInstance(Vacancy::class);
                            $newVacancy->setInteramtUid($odVacancy['Id']);
                            $newVacancy->setTitle($odVacancy['StellenBezeichnung']);
                            $newVacancy->setAuthority($odAuthority->getUid());
                            $newVacancy->setAuthorityObject($odAuthority);
                            $newVacancy->setLocationZip($odVacancy['Plz']);
                            $newVacancy->setLocationCity($odVacancy['Ort']);
                            $newVacancy->setDetailLinkParam($odVacancy['Id'].'-'.$odAuthority->getUid());

                            if($odVacancy['Daten']['Eingestellt'] !== '') {
                                $tenderDate = new \DateTime('now', new \DateTimeZone('Europe/Berlin'));
                                $tenderDate->setTimestamp(strtotime($odVacancy['Daten']['Eingestellt']));
                                $newVacancy->setTenderDate($tenderDate);
                            }
                            if($odVacancy['Daten']['Bewerbungsfrist'] !== '') {
                                if((int) $odVacancy['Daten']['Bewerbungsfrist'] >= 1) {
                                    $deadline = new \DateTime('now', new \DateTimeZone('Europe/Berlin'));
                                    $deadline->setTimestamp(strtotime($odVacancy['Daten']['Bewerbungsfrist']));
                                    $newVacancy->setApplicationDeadline($deadline);
                                }
                            }
                            $vacancies[] = $newVacancy;
                        }
                    }
                }
            } else {
                /* get dataset from fallback */
                $vacancies = $this->vacancyRepository->findAllByDemand($demand);
                $vacancies = $this->vacancyRepository->expandVacancies($vacancies, $this->settings['authorities']);
            }
        }

        $this->view->assign('vacancies', $vacancies);
        $this->view->assign('sh', bin2hex(json_encode($this->searchHash)));
        $this->view->assign('sHash', $this->searchHash);
        $this->view->assign('activeFilters', $activeFilters);
        return $this->htmlResponse();
    }

    public function showAction(): ResponseInterface {
        $vacancyUid = $this->request->getArgument('vacancy') ?? null;
        $sh = '';
        if($this->request->hasArgument('sh')) {
            $sh = $this->request->getArgument('sh');
        }
        if(!$vacancyUid) {
            $this->view->assign('no_data', true);
        } else {
            $connectorService = GeneralUtility::makeInstance(ConnectorService::class);
            if($this->settings['behaviour'] === 'onFly' && $connectorService->serviceIsOnline($this->settings['extension'])) {
                /* get dataset live from api */
                $detailParam = GeneralUtility::intExplode('-', $vacancyUid, true);
                $authority = $this->authorityRepository->findByUid($detailParam[1]);
                $vacancyInput = $connectorService->collectVacancyByUid($this->settings['extension'],$detailParam[0]);
                $vacancy = $this->vacancyRepository->buildVacancyModelFromConnector($vacancyInput, $authority,
                    $this->settings);
                $contact = $this->vacancyRepository->buildContactPerson($vacancy);
            } else {
                /* get dataset from fallback */
                $vacancy = $this->vacancyRepository->findByInteramtUid($vacancyUid);
                $authority = $this->authorityRepository->findByUid($vacancy->getAuthority());
                $contact = $this->vacancyRepository->buildContactPerson($vacancy);
            }

            if(!$vacancy) {
                $this->view->assign('no_data', true);
            } else {
                /** @var Vacancy $vacancy */
                $vacancy->setBesoldung();
                $this->view->assign('vacancy', $vacancy);
                $this->view->assign('authority', $authority);
                $this->view->assign('contact', $contact);

                $this->titleProvider->setTitle($vacancy->getTitle());
            }
        }
        $this->view->assign('sh', $sh);
        return $this->htmlResponse();
    }

    public function searchAction(): ResponseInterface {
        $this->titleProvider->setTitle('INTERAMT Detailsuche');
        if($this->request->hasArgument('start')) {
            $params = $this->request->getArguments();
            $searchHash = [];
            if(array_key_exists('free_text', $params)) {
                $searchHash['t'] = trim($params['free_text']);
            } else {
                $searchHash['t'] = '';
            }

            if(array_key_exists('duration', $params)) {
                $durationUid = (int) $params['duration'];
                $searchHash['d'] = $durationUid;
                $this->setRadioFieldValue('duration', $durationUid);
            } else {
                $searchHash['d'] = 0;
            }

            if(array_key_exists('workTime', $params)) {
                $workTimeUid = (int) $params['workTime'];
                $searchHash['w'] = $workTimeUid;
                $this->setRadioFieldValue('workTime', $workTimeUid);
            } else {
                $searchHash['w'] = 0;
            }

            if(array_key_exists('areas', $params)) {
                $searchHash['a'] = (!is_array($params['areas']) ? [] : $params['areas']);
                $this->setCheckboxFieldValue('area', $searchHash['a']);
            } else {
                $searchHash['a'] = [];
            }

            if(array_key_exists('contracts', $params)) {
                $searchHash['c'] = (!is_array($params['contracts']) ? [] : $params['contracts']);
                $this->setCheckboxFieldValue('contract', $searchHash['c']);
            } else {
                $searchHash['c'] = [];
            }

            $listUri = $this->uriBuilder->uriFor('list', ['sh' => bin2hex(json_encode($searchHash))]);
            return $this->responseFactory->createResponse()->withHeader('Location', $listUri);
        } else {
            $searchHash = $this->searchHash;
        }

        $this->view->assign('searchContracts', $this->searchContracts);
        $this->view->assign('searchArea', $this->searchArea);
        $this->view->assign('searchDuration', $this->searchDuration);
        $this->view->assign('searchWorkTime', $this->searchWorkTime);
        $this->view->assign('sh', $searchHash);
        return $this->htmlResponse();
    }

    private function setRadioFieldValue(string $type, int $uid) {
        if($type === 'duration') {
            foreach($this->searchDuration as $durationUid => $options) {
                if($durationUid === $uid) {
                    $this->searchDuration[$durationUid]['selected'] = true;
                } else {
                    $this->searchDuration[$durationUid]['selected'] = false;
                }
            }
        }
        if($type === 'workTime') {
            foreach($this->searchWorkTime as $workTimeUid => $options) {
                if($workTimeUid === $uid) {
                    $this->searchWorkTime[$workTimeUid]['selected'] = true;
                } else {
                    $this->searchWorkTime[$workTimeUid]['selected'] = false;
                }
            }
        }
    }

    private function setCheckboxFieldValue(string $type, array $uidStringList) {
        $uidList = GeneralUtility::intExplode(',', implode(',', $uidStringList), true);
        if($type === 'area') {
            foreach($this->searchArea as $areaUid => $options) {
                if(in_array($areaUid, $uidList, true)) {
                    $this->searchArea[$areaUid]['selected'] = true;
                } else {
                    $this->searchArea[$areaUid]['selected'] = false;
                }
            }
        }
        if($type === 'contract') {
            foreach($this->searchContracts as $contractUid => $options) {
                if(in_array($contractUid, $uidList, true)) {
                    $this->searchContracts[$contractUid]['selected'] = true;
                } else {
                    $this->searchContracts[$contractUid]['selected'] = false;
                }
            }
        }
    }

    private function collectActiveFilters(array $demand): array {
        $result = [];
        $activeFilters = [];
        $filters = [];

        if(array_key_exists('t', $this->searchHash)) {
            if(trim($this->searchHash['t']) !== '') {
                $activeFilters['free_text'] = $this->searchHash['t'];
                $filters['free_text'] = GeneralUtility::trimExplode(' ', $this->searchHash['t']);
            } else {
                $activeFilters['free_text'] = null;
                $filters['free_text'] = null;
            }
        }

        if(array_key_exists('d', $this->searchHash)) {
            $durationUid = $this->searchHash['d'];
            if($durationUid > 0) {
                $activeFilters['duration'] = $this->searchDuration[$durationUid]['title'];
                $filters['duration'] = [$this->searchDuration[$durationUid]['title'], $durationUid];
            } else {
                $activeFilters['duration'] = null;
                $filters['duration'] = null;
            }
        }

        if(array_key_exists('w', $this->searchHash)) {
            $workTimeUid = $this->searchHash['w'];
            if($workTimeUid > 0) {
                $activeFilters['workTime'] = $this->searchWorkTime[$workTimeUid]['title'];
                $filters['workTime'] = [$this->searchWorkTime[$workTimeUid]['title'], $workTimeUid];
            } else {
                $activeFilters['workTime'] = null;
                $filters['workTime'] = 0;
            }
        }

        if(array_key_exists('a', $this->searchHash)) {
            $areas = $this->searchHash['a'];
            if(\count($areas) > 0) {
                $fA = [];
                $aA = [];
                foreach($areas as $area) {
                    $areaElement = $this->searchArea[(int) $area];
                    $fA[] = [$areaElement['title'], (int) $area];
                    $aA[] = $areaElement['title'];
                }
                sort($aA);
                $activeFilters['areas'] = implode(', ', $aA);
                $filters['areas'] = $fA;
            } else {
                $activeFilters['areas'] = null;
                $filters['areas'] = null;
            }
        }

        if(array_key_exists('c', $this->searchHash)) {
            $contracts = $this->searchHash['c'];
            if(\count($contracts) > 0) {
                $fC = [];
                $aC = [];
                foreach($contracts as $contract) {
                    $contractElement = $this->searchContracts[(int) $contract];
                    $fC[] = [$contractElement['title'], (int) $contract];
                    $aC[] = $contractElement['title'];
                }
                sort($aC);
                $activeFilters['contracts'] = implode(', ', $aC);
                $filters['contracts'] = $fC;
            } else {
                $activeFilters['contracts'] = null;
                $filters['contracts'] = null;
            }
        }

        $demand['filter'] = $filters;
        $result['demand'] = $demand;
        $result['activeFilters'] = $activeFilters;
        return $result;
    }
}
