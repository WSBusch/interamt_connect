<?php

namespace WSBusch\InteramtConnect\Provider;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

class PageTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title): void {
        $this->title = $title;
    }
}