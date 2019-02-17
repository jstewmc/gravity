<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Data;

class Setting extends Path
{
    public static function getSeparator(): string
    {
        return '.';
    }
}
