<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Exception;

class NotReadable extends Exception
{
    public function __construct(string $pathname)
    {
        parent::__construct($pathname);

        $this->message = "'{$pathname}' does not exist or is not readable";
    }
}
