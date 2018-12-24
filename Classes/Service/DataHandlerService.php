<?php
namespace MichielRoos\WizardCrpagetree\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use MichielRoos\WizardCrpagetree\Utility\LanguageUtility;
/**
 * Class DataHandlerService
 * @package MichielRoos\WizardCrpagetree\Utility
 */
class DataHandlerService
{

    /**
     * @var int
     */
    public $thePid = 0;

    /**
     * @var string
     */
    public $separationChar = '';

    /**
     * @var string
     */
    public $indentationChar = '';

    /**
     * @var array
     */
    public $extraFields = [];

    /**
     * @param array $data
     * @return mixed
     */
    public function prepareData($data = [])
    {
        $result = '';

        if ($data) {
            $pageIndex = count($data);
            $sorting = count($data);
            $oldLevel = 0;
            $parentPid = [];
            $currentPid = 0;
            foreach ($data as $key => $line) {
                if (trim($line)) {
                    // What level are we on?
                    preg_match('/^' . $this->indentationChar . '*/', $line, $regs);
                    $level = strlen($regs[0]);

                    if ($level == 0) {
                        $currentPid = $this->thePid;
                        $parentPid[$level] = $this->thePid;
                    } elseif ($level > $oldLevel) {
                        $currentPid = 'NEW' . ($pageIndex - 1);
                        $parentPid[$level] = $pageIndex - 1;
                    } elseif ($level === $oldLevel) {
                        $currentPid = 'NEW' . $parentPid[$level];
                    } elseif ($level < $oldLevel) {
                        $currentPid = 'NEW' . $parentPid[$level];
                    }

                    // Get title and additional field values
                    $parts = GeneralUtility::trimExplode($this->separationChar, $line);

                    $pageTree['pages']['NEW' . $pageIndex]['title'] = ltrim($parts[0], $this->indentationChar);
                    $pageTree['pages']['NEW' . $pageIndex]['pid'] = $currentPid;
                    $pageTree['pages']['NEW' . $pageIndex]['sorting'] = $sorting--;
                    $pageTree['pages']['NEW' . $pageIndex]['hidden'] = GeneralUtility::_POST('hidePages') ? 1 : 0;

                    // Drop the title
                    array_shift($parts);

                    // Add additional field values
                    if ($this->extraFields) {
                        foreach ($this->extraFields as $index => $field) {
                            $pageTree['pages']['NEW' . $pageIndex][$field] = $parts[$index];
                        }
                    }
                    $oldLevel = $level;
                    $pageIndex++;
                }
            }
        }

        if (count($pageTree['pages'])) {
            reset($pageTree);
            $tce = GeneralUtility::makeInstance(DataHandler::class);
            $tce->stripslashes_values = 0;
            $tce->start($pageTree, []);
            $tce->process_datamap();
            BackendUtility::setUpdateSignal('updatePageTree');
        } else {
            $result .= $GLOBALS['TBE_TEMPLATE']->rfw(LanguageUtility::getLanguageLabel('wiz_newPageTree_noCreate') . '<br /><br />');
        }

        return $result;
    }
}
