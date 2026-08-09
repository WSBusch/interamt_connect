<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use WSBusch\InteramtConnect\FormEngine\InteramtConnectPreviewRenderer;

defined('TYPO3') or die;

$pluginSignature = ExtensionUtility::registerPlugin(
    'interamt_connect',
    'Connector',
    'LLL:EXT:interamt_connect/Resources/Private/Language/locallang.xlf:interamt_plugin.title',
    'interamt_connect-plugin-connector',
    'plugins',
    'LLL:EXT:interamt_connect/Resources/Private/Language/locallang.xlf:interamt_plugin.description',
    'FILE:EXT:interamt_connect/Configuration/FlexForms/VacanciesList.xml',
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,pi_flexform,',
    $pluginSignature,
    'after:subheader',
);


$GLOBALS['TCA']['tt_content']['types'][$pluginSignature]['previewRenderer'] = InteramtConnectPreviewRenderer::class;

ExtensionManagementUtility::addToInsertRecords('tt_address');
