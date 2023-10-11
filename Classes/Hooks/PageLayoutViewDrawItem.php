<?php

namespace WSBusch\InteramtConnect\Hooks;

use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;

class PageLayoutViewDrawItem implements PageLayoutViewDrawItemHookInterface
{
    public function preProcess(
        PageLayoutView &$parentObject,
        &$drawItem,
        &$headerContent,
        &$itemContent,
        array &$row
    ): void {
        $itemContent .= '<div class="content_preview content_preview_111">';
        $itemContent .= 'TEST';
        $itemContent .= '</div>';
    }
}