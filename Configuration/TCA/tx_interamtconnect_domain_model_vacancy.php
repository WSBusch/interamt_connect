<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy',
        'label' => 'interamt_uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
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
        'searchFields' => 'identifier,title,location_street,location_zip,location_city,description,latitude,longitude,contracts,careers,salary_group_from,salary_group_to,tariff_level_from,tariff_level_to,qualification,training,responsibilities,subject_area,work_time,weekly_working_time_civil_servant,weekly_working_time_employee,duration_of_employment,limited_to,occupation_to,application_process,application_url,required_studies,attachments,contact_lastname,contact_firstname,contact_salutaion,contact_street,contact_zip,contact_city,contact_authority,contact_phone,contact_mobile,contact_fax,contact_email,import_hash',
        'iconfile' => 'EXT:interamt_connect/Resources/Public/Icons/tx_interamtconnect_domain_model_vacancy.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'interamt_uid, authority, identifier, title, description, number_of_vacancies, contracts, careers, salary_group_from, salary_group_to, tariff_level_from, tariff_level_to, qualification, training, training_duration, responsibilities, subject_area, work_time, weekly_working_time_civil_servant, weekly_working_time_employee, duration_of_employment, limited_to, application_deadline, occupation_to, last_changes, tender_date, application_process, application_url, required_studies, attachments, --div--;Einsatzort,location_street, location_zip, location_city,latitude, longitude,--div--;Ansprechpartner, contact_lastname, contact_firstname, contact_salutaion, contact_street, contact_zip, contact_city, contact_authority, contact_phone, contact_mobile, contact_fax, contact_email, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
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
                'foreign_table' => 'tx_interamtconnect_domain_model_vacancy',
                'foreign_table_where' => 'AND {#tx_interamtconnect_domain_model_vacancy}.{#pid}=###CURRENT_PID### AND {#tx_interamtconnect_domain_model_vacancy}.{#sys_language_uid} IN (-1,0)',
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
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.interamt_uid',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required',
                'default' => 0
            ]
        ],
        'authority' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.authority',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_interamtconnect_domain_model_authority',
                'maxitems' => 1,
                'minitems' => 1,
                'size' => 1,
            ]
        ],
        'identifier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.identifier',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'title' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'location_street' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.location_street',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'location_zip' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.location_zip',
            'config' => [
                'type' => 'input',
                'size' => 8,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'location_city' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.location_city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => '',
                'enableRichtext' => true
            ],
        ],
        'latitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.latitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'longitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.longitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'number_of_vacancies' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.number_of_vacancies',
            'config' => [
                'type' => 'input',
                'size' => 3,
                'eval' => 'int,required',
                'default' => 1
            ]
        ],
        'contracts' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contracts',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'careers' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.careers',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'salary_group_from' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.salary_group_from',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'salary_group_to' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.salary_group_to',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'tariff_level_from' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.tariff_level_from',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'tariff_level_to' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.tariff_level_to',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'qualification' => [
            'exclude' => true,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.qualification',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'training' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.training',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'training_duration' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.training_duration',
            'config' => [
                'type' => 'input',
                'size' => 3,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'responsibilities' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.responsibilities',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'subject_area' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.subject_area',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'work_time' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.work_time',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'weekly_working_time_civil_servant' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.weekly_working_time_civil_servant',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'weekly_working_time_employee' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.weekly_working_time_employee',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'duration_of_employment' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.duration_of_employment',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'limited_to' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.limited_to',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'application_deadline' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.application_deadline',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime,null',
                'default' => null,
            ],
        ],
        'occupation_to' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.occupation_to',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'last_changes' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.last_changes',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime',
                'default' => null,
            ],
        ],
        'tender_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.tender_date',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime,null',
                'default' => null,
            ],
        ],
        'application_process' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.application_process',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'default' => ''
            ],
        ],
        'application_url' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.application_url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'required_studies' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.required_studies',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 10,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'attachments' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.attachments',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 10,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'contact_lastname' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_lastname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_firstname' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_firstname',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_salutaion' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_salutaion',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_street' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_street',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_zip' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_zip',
            'config' => [
                'type' => 'input',
                'size' => 8,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_city' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_authority' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_authority',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_phone' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_mobile' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_mobile',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_fax' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_fax',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'contact_email' => [
            'exclude' => false,
            'label' => 'LLL:EXT:interamt_connect/Resources/Private/Language/locallang_db.xlf:tx_interamtconnect_domain_model_vacancy.contact_email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'nospace,email',
                'default' => ''
            ]
        ],
        'import_hash' => [
            'exclude' => true,
            'label' => 'Import-Hash',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'default' => '',
                'readOnly' => true
            ]
        ],
    ],
];
