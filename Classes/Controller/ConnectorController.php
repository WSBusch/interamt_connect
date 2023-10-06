<?php
declare(strict_types=1);

namespace WSBusch\InteramtConnect\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use WSBusch\InteramtConnect\Domain\Model\Vacancy;
use WSBusch\InteramtConnect\Domain\Repository\VacancyRepository;
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
     * @var array
     */
    protected $settings = [];

    /**
     * @param VacancyRepository $vacancyRepository
     */
    public function injectVacancyRepository(VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function initializeAction()
    {
        $this->settings = ConfigurationService::parseSettings($this->settings);

        DebuggerUtility::var_dump($this->settings);
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

        $vacancies = [];
        if(\count($this->settings['authorities']) > 0) {
            $connectorService = GeneralUtility::makeInstance(ConnectorService::class);
            if($this->settings['behaviour'] === 'on-fly' && $connectorService->serviceIsOnline($this->settings['extension'])) {
                /* get dataset live from api */
            } else {
                /* get dataset from fallback */
                $vacancies = $this->vacancyRepository->findAllByDemand($demand);
            }
        }

        $this->view->assign('vacancies', $vacancies);
        return $this->htmlResponse();
    }

    public function showAction(): ResponseInterface {
        $vacancyUid = $this->request->getArgument('vacancy') ?? null;
        if(!$vacancyUid) {
            $this->view->assign('no_data', true);
        } else {
            $connectorService = GeneralUtility::makeInstance(ConnectorService::class);
            if($this->settings['behaviour'] === 'on-fly' && $connectorService->serviceIsOnline($this->settings['extension'])) {
                /* get dataset live from api */
                $vacancy = null;
            } else {
                /* get dataset from fallback */
                $vacancy = $this->vacancyRepository->findByInteramtUid($vacancyUid);
            }

            if(!$vacancy) {
                $this->view->assign('no_data', true);
            } else {
                $this->view->assign('vacancy', $vacancy);
            }
        }
        return $this->htmlResponse();
    }
}
