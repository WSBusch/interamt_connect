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
     * @var int
     */
    protected int $searchIdentifier = 0;

    /**
     * @var string
     */
    protected string $searchText = '';

    /**
     * @var string|null
     */
    protected ?string $searchDate = null;

    /**
     * @return int
     */
    public function getSearchIdentifier(): int {
        return $this->searchIdentifier;
    }

    /**
     * @param int $searchIdentifier
     * @return void
     */
    public function setSearchIdentifier(int $searchIdentifier): void {
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
     * @return string|null
     */
    public function getSearchDate(): ?string {
        return $this->searchDate;
    }

    /**
     * @param string $searchDate
     * @return void
     */
    public function setSearchDate(string $searchDate): void {
        $this->searchDate = $searchDate;
    }
}
