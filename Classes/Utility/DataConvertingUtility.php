<?php

namespace MichielRoos\WizardCrpagetree\Utility;

/**
 * Class DataConvertingUtility
 * @package MichielRoos\WizardCrpagetree\Utility
 */
class DataConvertingUtility
{

    /**
     * Return the data as a nested array
     *
     * @param array $data : the data array
     * @param int $oldLevel : the current level
     * @param string $character : indentation character
     *
     * @return array
     */
    public static function generateNestedArray($data, $oldLevel = 0, $character = ' ')
    {
        $size = count($data);
        $newData = [];
        for ($i = 0; $i < $size;) {
            $regs = [];
            $value = $data[$i];
            if (trim($value)) {
                // What level are we on?
                preg_match('/^' . $character . '*/', $value, $regs);
                $level = strlen($regs[0]);

                if ($level > $oldLevel) {
                    /**
                     * We have entered a sub level. Find the chunk of the array that
                     * constitues this sub level. Pass this chunk to the getArray
                     * function. Then increase the $i to point to the point where the
                     * level is the same as we are on now.
                     */
                    $subData = [];
                    for ($j = $i; $j < $size; $j++) {
                        $regs = [];
                        $value = $data[$j];
                        if (trim($value)) {
                            // What level are we on?
                            preg_match('/^' . $character . '*/', $value, $regs);
                            $subLevel = strlen($regs[0]);
                            if ($subLevel >= $level) {
                                $subData[] = $value;
                            } else {
                                break;
                            }
                        }
                    }
                    $newData[$i - 1]['data'] = self::generateNestedArray($subData, $level, $character);
                    $i = $i + count($subData);
                } elseif (($level == 0) or ($level === $oldLevel)) {
                    $newData[$i]['value'] = $value;
                    $i++;
                }
                $oldLevel = $level;
            }
            if ($i == $size) {
                break;
            }
        }

        return $newData;
    }

    /**
     * Return the data with all the leaves sorted in reverse order
     *
     * @param array $data : input array
     *
     * @return array
     */
    public static function reverseArray($data)
    {
        $newData = [];
        $index = 0;
        foreach ($data as $chunk) {
            if (is_array($chunk['data'])) {
                $newData[$index]['data'] = self::reverseArray($chunk['data']);
                krsort($newData[$index]['data']);
            }
            $newData[$index]['value'] = $chunk['value'];
            $index++;
        }
        krsort($newData);

        return $newData;
    }

    /**
     * Return the data as a compressed array
     *
     * @param array $data : the uncompressed array
     *
     * @return array
     */
    public static function compressArray($data)
    {
        $newData = [];
        foreach ($data as $value) {
            if ($value['value']) {
                $newData[] = $value['value'];
            }
            if ($value['data']) {
                $newData = array_merge($newData, self::compressArray($value['data']));
            }
        }

        return $newData;
    }

    /**
     * Return the data without comment fields and empty lines
     *
     * @param array $data : input array
     *
     * @return array
     */
    public static function filterComments($data)
    {
        $newData = [];
        $multiLine = false;
        foreach ($data as $value) {
            // Multiline comment
            if (preg_match('#^/\*#', $value) and !$multiLine) {
                $multiLine = true;
                continue;
            }
            if (preg_match('#[\*]+/#', ltrim($value)) and $multiLine) {
                $multiLine = false;
                continue;
            }
            if ($multiLine) {
                continue;
            }
            // Single line comment
            if (preg_match('#^//#', ltrim($value)) or preg_match('/^#/', ltrim($value))
            ) {
                continue;
            }

            // Empty line
            if (!trim($value)) {
                continue;
            }

            $newData[] = $value;
        }

        return $newData;
    }

}
