<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Data;

use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Script\Data\Parsed as Script;

/**
 * String identifiers have been parsed into paths.
 */
class Parsed extends File
{
    public function __construct(string $pathname, Ns $namespace, Script $script)
    {
        parent::__construct($pathname, $namespace, $script);
    }
}
