<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(
    function () {
        if (TYPO3_MODE == 'BE') {
            TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
                'web_func',
                \MichielRoos\WizardCrpagetree\WebFunction\CreatePageTree::class,
                null,
                'LLL:EXT:wizard_crpagetree/Resources/Private/Language/locallang.xml:wiz_crPageTree'
            );
            TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
                '_MOD_web_func',
                'EXT:wizard_crpagetree/Resources/Private/Language/ContextSensitiveHelp/default.xml'
            );
        }
    }
);
