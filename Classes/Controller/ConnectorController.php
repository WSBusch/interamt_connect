<?php
declare(strict_types=1);

namespace WSBusch\InteramtConnect\Controller;

use Psr\Http\Message\ResponseInterface;
use WSBusch\InteramtConnect\Domain\Model\Vacancy;
use WSBusch\InteramtConnect\Domain\Repository\VacancyRepository;

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
     * @var VacancyRepository
     */
    protected $vacancyRepository = null;

    /**
     * @param VacancyRepository $vacancyRepository
     */
    public function injectVacancyRepository(VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $vacancies = $this->vacancyRepository->findAll();
        $this->view->assign('vacancies', $vacancies);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param Vacancy $vacancy
     * @return ResponseInterface
     */
    public function showAction(Vacancy $vacancy): ResponseInterface
    {
        $this->view->assign('vacancy', $vacancy);
        return $this->htmlResponse();
    }
}
