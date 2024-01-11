<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

ExtensionUtility::registerPlugin(
    'InteramtConnect',
    'Connector',
    'Interamt Connector'
);

$pluginPi1Signature = 'interamtconnect_connector';

$contentTypeName = 'list';
$GLOBALS['TCA']['tt_content']['types'][$contentTypeName]['subtypes_addlist'][$pluginPi1Signature] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue(
    $pluginPi1Signature,
    'FILE:EXT:interamt_connect/Configuration/FlexForms/VacanciesList.xml',
    $contentTypeName
);
$GLOBALS['TCA']['tt_content']['types'][$contentTypeName]['subtypes_excludelist'][$pluginPi1Signature] = 'recursive,select_key,pages';

$GLOBALS['TCA']['tt_content']['types'][$contentTypeName]['previewRenderer'][$pluginPi1Signature]  = \WSBusch\InteramtConnect\Hooks\PluginPreviewRenderer::class;