<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Data;

use Jstewmc\Gravity\Ns\Data\Closed as Ns;
use Jstewmc\Gravity\Script\Data\Closed as Script;

/**
 * Immutable.
 */
class Closed extends File
{
    public function __construct(string $pathname, Ns $namespace, Script $script)
    {
        parent::__construct($pathname, $namespace, $script);
    }
}
