<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

$pluginPi1Signature = ExtensionUtility::registerPlugin(
    'InteramtConnect',
    'Connector',
    'Interamt Connector'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginPi1Signature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $pluginPi1Signature,
    'FILE:EXT:interamt_connect/Configuration/FlexForms/VacanciesList.xml'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginPi1Signature] = 'recursive,select_key,pages';