<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'InteramtConnect',
        'Connector',
        [
            \WSBusch\InteramtConnect\Controller\ConnectorController::class => 'list, show'
        ],
        // non-cacheable actions
        [
            \WSBusch\InteramtConnect\Controller\ConnectorController::class => 'list, show'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    connector {
                        iconIdentifier = interamt_connect-plugin-connector
                        title = LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamt_connect_connector.name
                        description = LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamt_connect_connector.description
                        tt_content_defValues {
                            CType = list
                            list_type = interamtconnect_connector
                        }
                    }
                }
                show = *
            }
       }'
    );
})();
