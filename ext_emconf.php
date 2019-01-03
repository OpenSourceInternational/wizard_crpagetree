<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Web>Func, Wizards, Create page tree',
    'description' => 'Wizard that will create a page tree for you. Feed it with a space indented tree structure of the desired pages and the pages will be created for you.',
    'category' => 'module',
    'shy' => 0,
    'version' => '1.2.0',
    'dependencies' => 'func',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => 0,
    'lockType' => '',
    'autoload' => array(
        'psr-4' => array('MichielRoos\\WizardCrpagetree\\' => 'Classes'),
        'classmap' => array('Classes')
    ),
    'author' => 'Michiel Roos',
    'author_email' => 'extensions@donationbasedhosting.org',
    'author_company' => 'Donation Based Hosting',
    'CGLcompliance' => '',
    'CGLcompliance_note' => '',
    'constraints' => array(
        'depends' => array(
            'func' => '',
            'typo3' => '9.0.0-9.5.99',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
    'suggests' => array(),
    '_md5_values_when_last_written' => 's:0:""',
);
