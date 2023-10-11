<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use WSBusch\InteramtConnect\Controller\ConnectorController;

defined('TYPO3') || die();

(static function() {
    ExtensionUtility::configurePlugin(
        'InteramtConnect',
        'Connector',
        [
            ConnectorController::class => 'list, show, search'
        ],
        // non-cacheable actions
        [
            ConnectorController::class => 'list, show, search'
        ]
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['interamtconnect'] = \WSBusch\InteramtConnect\Hooks\PageLayoutViewDrawItem::class;


})();
