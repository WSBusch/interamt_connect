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
 * Authority
 */
class Searches extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     */
    protected string $searchIdentifier = '';

    /**
     * @var string
     */
    protected string $searchText = '';

    /**
     * @var \Datetime|null
     */
    protected ?\Datetime $searchDate = null;

    /**
     * @return string
     */
    public function getSearchIdentifier(): string {
        return $this->searchIdentifier;
    }

    /**
     * @param string $searchIdentifier
     * @return void
     */
    public function setSearchIdentifier(string $searchIdentifier): void {
        $this->searchIdentifier = $searchIdentifier;
    }

    /**
     * @return string
     */
    public function getSearchText(): string {
        return $this->searchText;
    }

    /**
     * @param string $searchText
     * @return void
     */
    public function setSearchText(string $searchText): void {
        $this->searchText = $searchText;
    }

    /**
     * @return \DateTime|null
     */
    public function getSearchDate(): ?\DateTime {
        return $this->searchDate;
    }

    /**
     * @param \DateTime $searchDate
     * @return void
     */
    public function setSearchDate(\DateTime $searchDate): void {
        $this->searchDate = $searchDate;
    }
}
