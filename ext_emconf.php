<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Interamt Connector',
    'description' => 'Creates an overview of all job advertisements of a public authority, which are listed in the public service job portal INTERAMT.de.',
    'category' => 'plugin',
    'author' => 'Oliver Busch',
    'author_email' => 'oliver@busch-oliver.de',
    'author_company' => 'Webservice Oliver Busch',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
