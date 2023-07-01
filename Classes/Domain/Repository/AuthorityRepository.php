<?php

declare(strict_types=1);

namespace WSBusch\InteramtConnect\Domain\Repository;


/**
 * This file is part of the "Interamt Connector" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2023 Oliver Busch <oliver@busch-oliver.de>, Webservice Busch
 */

/**
 * The repository for Authorities
 */
class AuthorityRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = ['sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING];

    public function findAllForTask() {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        return $query->execute();
    }
}
