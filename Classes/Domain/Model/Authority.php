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
class Authority extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * interamtUid
     *
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $interamtUid = null;

    /**
     * title
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = null;

    /**
     * storageUid
     *
     * @var int
     */
    protected $storageUid = null;

    /**
     * description
     *
     * @var string
     */
    protected $description = null;

    /**
     * website
     *
     * @var string
     */
    protected $website = null;

    /**
     * Returns the interamtUid
     *
     * @return int
     */
    public function getinteramtUid()
    {
        return $this->interamtUid;
    }

    /**
     * Sets the interamtUid
     *
     * @param string $interamtUid
     * @return void
     */
    public function setinteramtUid(int $interamtUid)
    {
        $this->interamtUid = $interamtUid;
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
     * Returns the storageUid
     *
     * @return int
     */
    public function getStorageUid()
    {
        return $this->storageUid;
    }

    /**
     * Sets the storageUid
     *
     * @param int $storageUid
     * @return void
     */
    public function setStorageUid(int $storageUid)
    {
        $this->storageUid = $storageUid;
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
     * Returns the website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Sets the website
     *
     * @param string $website
     * @return void
     */
    public function setWebsite(string $website)
    {
        $this->website = $website;
    }
}
