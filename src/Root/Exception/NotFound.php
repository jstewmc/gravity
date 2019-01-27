<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Exception;

class NotFound extends Exception
{
    public function __construct()
    {
        $this->message = "Root directory not found";
    }
}
