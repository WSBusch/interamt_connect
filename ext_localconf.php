<?php

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
            ConnectorController::class => 'list, search'
        ]
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
        'interamt_connect',
        'setup',
        "@import 'EXT:interamt_connect/Configuration/TypoScript/setup.typoscript'"
    );
})();
