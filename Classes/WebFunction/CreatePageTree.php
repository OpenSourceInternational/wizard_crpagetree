<?php

namespace MichielRoos\WizardCrpagetree\WebFunction;

/**
 *  Copyright notice
 *
 *  ⓒ 2015 Michiel Roos <michiel@maxserv.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is free
 *  software; you can redistribute it and/or modify it under the terms of the
 *  GNU General Public License as published by the Free Software Foundation;
 *  either version 2 of the License, or (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful, but
 *  WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 *  or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 */

use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Tree\View\BrowseTreeView;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use MichielRoos\WizardCrpagetree\Utility\DataConvertingUtility;
use MichielRoos\WizardCrpagetree\Utility\LanguageUtility;
use MichielRoos\WizardCrpagetree\Utility\RequestUtility;
use MichielRoos\WizardCrpagetree\Service\ViewService;
use MichielRoos\WizardCrpagetree\Service\DataHandlerService;

/**
 * Creates the "Create pagetree" wizard
 *
 * @author Michiel Roos <extensions@donationbasedhosting.org>
 * @package TYPO3
 * @subpackage tx_wizardcrpagetree
 */
class CreatePageTree
{
    /**
     * The integer value of the GET/POST var, 'id'. Used for submodules to the 'Web' module (page id)
     *
     * @see init()
     * @var int
     */
    public $id;

    /**
     * @var ModuleTemplate
     */
    public $moduleTemplate;

    /**
     * @var ViewService
     */
    public $viewService;

    /**
     * @var DataHandlerService
     */
    public $dataHandlerService;

    /**
     * Initialize the object
     *
     * @param \object $pObj A reference to the parent (calling) object
     * @throws \RuntimeException
     * @see \TYPO3\CMS\Backend\Module\BaseScriptClass::checkExtObj()
     */
    public function init($pObj)
    {
        $this->id = (int)GeneralUtility::_GP('id');
        $this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->viewService = GeneralUtility::makeInstance(ViewService::class);
        $this->dataHandlerService = GeneralUtility::makeInstance(DataHandlerService::class);
    }

    /**
     * Main function creating the content for the module. Return HTML content.
     *
     * @return string
     */
    public function main()
    {
        $theCode = '';
        // create new pages here?
        $pRec = BackendUtility::getRecord('pages', $this->id, 'uid, title', ' AND ' . $GLOBALS['BE_USER']->getPagePermsClause(8));
        $sysPages = GeneralUtility::makeInstance(PageRepository::class);
        $menuItems = $sysPages->getMenu($this->id);

        if (is_array($pRec)) {
            if (GeneralUtility::_POST('newPageTree') === 'submit') {
                $data = explode("\r\n", GeneralUtility::_POST('data'));
                $data = DataConvertingUtility::filterComments($data);
                if (count($data)) {
                    if (GeneralUtility::_POST('createInListEnd')) {
                        $endI = end($menuItems);
                        $thePid = -intval($endI['uid']);
                        if (!$thePid) {
                            $thePid = $this->id;
                        }
                    } else {
                        // get parent pid
                        $thePid = $this->id;
                    }
                    $this->dataHandlerService->thePid = $thePid;

                    $indentationChar = RequestUtility::getIndentationChar();
                    $this->dataHandlerService->indentationChar = RequestUtility::getIndentationChar();
                    $this->dataHandlerService->separationChar = RequestUtility::getSeparationChar();
                    $this->dataHandlerService->extraFields = RequestUtility::getExtraFields();

                    // Reverse the ordering of the data
                    $originalData = DataConvertingUtility::generateNestedArray($data, 0, $indentationChar);
                    $reversedData = DataConvertingUtility::reverseArray($originalData);
                    $data = DataConvertingUtility::compressArray($reversedData);

                    $theCode .= $this->dataHandlerService->prepareData($data);

                    // Display result:
                    /** @var BrowseTreeView $tree */
                    $tree = GeneralUtility::makeInstance(BrowseTreeView::class);

                    /** @extensionScannerIgnoreLine */
                    $tree->init(' AND pages.doktype < 199 AND pages.hidden = "0"');
                    $tree->thisScript = 'index.php';
                    $tree->ext_IconMode = true;
                    $tree->expandAll = true;
                    $tree->clause .= ' OR hidden = 1 ';

                    $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
                    $tree->tree[] = [
                        'row' => $pRec,
                        'HTML' => $iconFactory->getIconForRecord('pages', [$thePid], Icon::SIZE_SMALL)->render()
                    ];

                    $tree->getTree($this->id);

                    $theCode .= LanguageUtility::getLanguageLabel('wiz_newPageTree_created');
                    $theCode .= $tree->printTree();
                }
            } else {
                $theCode .= $this->viewService->displayCreatForm();
            }
        } else {
            $theCode .= '<span>' . LanguageUtility::getLanguageLabel('wiz_newPageTree_errorMsg1') . '</span>';
        }

        // Context Sensitive Help
        $theCode .= BackendUtility::cshItem('_MOD_web_func', 'tx_wizardcrpagetree', $GLOBALS['BACK_PATH'], '<br/>|');

        $this->moduleTemplate->getView()->setTemplateSource($theCode);

        return $this->moduleTemplate->renderContent();
    }
}
