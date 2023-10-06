<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

ExtensionManagementUtility::addStaticFile(
    'interamt_connect',
    'Configuration/TypoScript',
    'Interamt Connector'
);
