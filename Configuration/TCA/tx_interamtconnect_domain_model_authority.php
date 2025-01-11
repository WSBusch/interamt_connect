<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_authority',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'searchFields' => 'title,description,website',
        'iconfile' => 'EXT:interamt_connect/Resources/Public/Icons/tx_interamtconnect_domain_model_authority.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'interamt_uid, title, storage_uid, description, website, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_interamtconnect_domain_model_authority',
                'foreign_table_where' => 'AND {#tx_interamtconnect_domain_model_authority}.{#pid}=###CURRENT_PID### AND {#tx_interamtconnect_domain_model_authority}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'interamt_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_authority.interamt_uid',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required',
                'default' => 0
            ]
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_authority.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'storage_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_authority.storage_uid',
            'config' => [
                'type' => 'group',
                'allowed' => 'pages',
                'maxitems' => 1,
                'minitems' => 1,
                'size' => 1,
            ]
        ],
        'description' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_authority.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => '',
                'enableRichtext' => true
            ]
        ],
        'website' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_authority.website',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
    
    ],
];
