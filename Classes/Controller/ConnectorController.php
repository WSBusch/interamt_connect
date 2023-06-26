<?php

declare(strict_types=1);

namespace WSBusch\InteramtConnect\Controller;


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
class ConnectorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * vacancyRepository
     *
     * @var \WSBusch\InteramtConnect\Domain\Repository\VacancyRepository
     */
    protected $vacancyRepository = null;

    /**
     * @param \WSBusch\InteramtConnect\Domain\Repository\VacancyRepository $vacancyRepository
     */
    public function injectVacancyRepository(\WSBusch\InteramtConnect\Domain\Repository\VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    /**
     * action list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function listAction(): \Psr\Http\Message\ResponseInterface
    {
        $vacancies = $this->vacancyRepository->findAll();
        $this->view->assign('vacancies', $vacancies);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param \WSBusch\InteramtConnect\Domain\Model\Vacancy $vacancy
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function showAction(\WSBusch\InteramtConnect\Domain\Model\Vacancy $vacancy): \Psr\Http\Message\ResponseInterface
    {
        $this->view->assign('vacancy', $vacancy);
        return $this->htmlResponse();
    }
}
