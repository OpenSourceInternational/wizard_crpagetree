<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (TYPO3_MODE == 'BE') {
    ExtensionManagementUtility::insertModuleFunction(
        'web_func',
        \MichielRoos\WizardCrpagetree\CreatePageTree::class,
        null,
        'LLL:EXT:wizard_crpagetree/Resources/Private/Language/locallang.xml:wiz_crPageTree'
    );
    ExtensionManagementUtility::addLLrefForTCAdescr(
        '_MOD_web_func',
        'EXT:wizard_crpagetree/Resources/Private/Language/ContextSensitiveHelp/default.xml'
    );
}
