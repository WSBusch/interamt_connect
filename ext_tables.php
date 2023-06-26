<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_interamtconnect_domain_model_authority', 'EXT:interamt_connect/Resources/Private/Language/locallang_csh_tx_interamtconnect_domain_model_authority.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_interamtconnect_domain_model_authority');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_interamtconnect_domain_model_vacancy', 'EXT:interamt_connect/Resources/Private/Language/locallang_csh_tx_interamtconnect_domain_model_vacancy.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_interamtconnect_domain_model_vacancy');
})();
