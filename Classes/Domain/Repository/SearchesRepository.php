<?php

declare(strict_types=1);

namespace WSBusch\InteramtConnect\Domain\Repository;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use WSBusch\InteramtConnect\Domain\Model\Searches;

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
class SearchesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findLastFromToday() {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $today = new \DateTime('now', new \DateTimeZone('Europe/Berlin'));
        $today->setTime(0,0);
        $query->setOrderings(['uid' => QueryInterface::ORDER_DESCENDING]);
        $query->matching($query->equals('search_date', $today->format('Y-m-d H:i:s')));
        return $query->execute()->getFirst();
    }

    public function findBySearchIdentifier(int $searchIdentifier) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('search_identifier', (string) $searchIdentifier));
        return $query->execute()->getFirst();
    }

    public function writeNewSearch($sh, $identifier, $update=false) {
        if($update) {
            /** @var Searches $search */
            $search = $this->findByUid($identifier);
            $search->setSearchText($sh);
            $this->update($search);
        } else {
            $today = new \DateTime('now', new \DateTimeZone('Europe/Berlin'));
            $today->setTime(0,0);
            $search = new Searches();
            $search->setSearchIdentifier($identifier);
            $search->setSearchText($sh);
            $search->setSearchDate($today->format('Y-m-d H:i:s'));
            $this->add($search);
        }
    }
}
