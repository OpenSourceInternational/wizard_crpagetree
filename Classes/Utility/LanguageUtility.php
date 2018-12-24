<?php
namespace MichielRoos\WizardCrpagetree\Utility;

/**
 * Class LanguageUtility
 * @package MichielRoos\WizardCrpagetree\Utility
 */
class LanguageUtility
{
    /**
     * Return translated string
     *
     * @param string $label
     *
     * @return string
     */
    public static function getLanguageLabel($label)
    {
        return $GLOBALS['LANG']->sL('LLL:EXT:wizard_crpagetree/Resources/Private/Language/locallang.xml:' . $label);
    }
}
