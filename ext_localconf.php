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
            ConnectorController::class => 'list, show'
        ],
        // non-cacheable actions
        [
            ConnectorController::class => 'list, show'
        ]
    );
})();
