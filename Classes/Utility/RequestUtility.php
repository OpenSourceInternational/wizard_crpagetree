<?php
namespace MichielRoos\WizardCrpagetree\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class RequestUtility
 * @package MichielRoos\WizardCrpagetree\Utility
 */
class RequestUtility
{
    /**
     * Get the indentation character (space, tab or dot)
     *
     * @return string
     */
    public static function getIndentationChar()
    {
        $character = GeneralUtility::_POST('indentationCharacter');
        switch ($character) {
            case 'dot':
                $character = '\.';
                break;
            case 'tab':
                $character = '\t';
                break;
            case 'space':
            default:
                $character = ' ';
                break;
        }

        return $character;
    }

    /**
     * Get the separation character (, or | or ; or :)
     *
     * @return string
     */
    public static function getSeparationChar()
    {
        $character = GeneralUtility::_POST('separationCharacter');
        switch ($character) {
            case 'pipe':
                $character = '|';
                break;
            case 'semicolon':
                $character = ';';
                break;
            case 'colon':
                $character = ':';
                break;
            case 'comma':
            default:
                $character = ',';
                break;
        }

        return $character;
    }

    /**
     * Get the extra fields
     *
     * @return array|bool
     */
    public static function getExtraFields()
    {
        $efLine = GeneralUtility::_POST('extraFields');
        if (trim($efLine)) {
            return GeneralUtility::trimExplode(' ', $efLine, 1);
        }

        return false;
    }

}
