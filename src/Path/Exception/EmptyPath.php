<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

/**
 * Empty is a reserved word.
 */
class EmptyPath extends Exception
{
    public function __construct()
    {
        $this->message = "Path is empty";
    }
}
