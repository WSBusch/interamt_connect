<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Interamt Connector',
    'description' => 'Creates an overview of all job advertisements of a public authority, which are listed in the public service job portal INTERAMT.de.',
    'category' => 'plugin',
    'author' => 'Oliver Busch, Sonja Buchheit',
    'author_email' => 'oliver@busch-oliver.de',
    'author_company' => 'Webservice Oliver Busch',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
