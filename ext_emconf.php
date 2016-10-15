<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Gemeinde Altrich Eventplanner',
    'description' => 'Eventplanner for the soctial centre. Manage volunteers for events to be organized',
    'category' => 'fe',
    'shy' => 0,
    'version' => '1.0.0',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => 1,
    'lockType' => '',
    'author' => 'TYPO3 GmbH Development team',
    'author_email' => 'info@typo3.com',
    'author_company' => 'TYPO3 GmbH',
    'CGLcompliance' => '',
    'CGLcompliance_note' => '',
    'constraints' => array(
        'depends' => array(
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    ),
    'autoload' =>
        array(
            'psr-4' => array('ALT\\AltEventplanner\\' => 'Classes')
        ),
);
