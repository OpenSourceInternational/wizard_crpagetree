<?php
namespace MichielRoos\WizardCrpagetree\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use MichielRoos\WizardCrpagetree\Utility\LanguageUtility;
/**
 * Class ViewService
 * @package MichielRoos\WizardCrpagetree\Utility
 */
class ViewService
{
    /**
     * Return html to display the creation form
     *
     * @return string
     */
    public function displayCreatForm()
    {
        $form = '
        <div class="module">
            <h1>' . LanguageUtility::getLanguageLabel('wiz_newPageTree') . ':</h1>
            <p>' . LanguageUtility::getLanguageLabel('wiz_newPageTree_howto') . '</p>
            <div class="form-group">
                <label for="indentationCharacter">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_indentationCharacter') . '</label>
                <select id="indentationCharacter" class="form-control" name="indentationCharacter">
                    <option value="space" selected="selected">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_indentationSpace') . '</option>
                    <option value="tab">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_indentationTab') . '</option>
                    <option value="dot">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_indentationDot') . '</option>
                </select>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="data"rows="8"/></textarea>
            </div>
            <div class="form-group">
                <input type="checkbox" name="createInListEnd" value="1" /> ' . LanguageUtility::getLanguageLabel('wiz_newPageTree_listEnd') . '
            </div>
            <div class="form-group">
                <input type="checkbox" name="hidePages" value="1" /> ' . LanguageUtility::getLanguageLabel('wiz_newPageTree_hidePages') . '
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-default" name="create" value="' . LanguageUtility::getLanguageLabel('wiz_newPageTree_lCreate') . '" onclick="return confirm(' . GeneralUtility::quoteJSvalue(LanguageUtility::getLanguageLabel('wiz_newPageTree_lCreate_msg1')) . ')">
                <input type="reset" class="btn btn-default" value="' . LanguageUtility::getLanguageLabel('wiz_newPageTree_lReset') . '" />
            </div>
            <h3>' . LanguageUtility::getLanguageLabel('wiz_newPageTree_advanced') . '</h3>
            <div class="form-group">
                <label for="extraFields">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_extraFields') . '</label>
                <input type="text" id="extraFields" class="form-control" name="extraFields" size="30" />
            </div>
            <div class="form-group">
                <label for="separationCharacter">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_separationCharacter') . '</label>
                <select name="separationCharacter" id="separationCharacter" class="form-control">
                    <option value="comma" selected="selected">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_separationComma') . '</option>
                    <option value="pipe">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_separationPipe') . '</option>
                    <option value="semicolon">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_separationSemicolon') . '</option>
                    <option value="colon">' . LanguageUtility::getLanguageLabel('wiz_newPageTree_separationColon') . '</option>
                </select>
            </div>
		    <input type="hidden" name="newPageTree" value="submit"/> 
		</div>';

        return $form;
    }
}

