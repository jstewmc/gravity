<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Exception;

class NotReadable extends Exception
{
    private $pathname;

    public function __construct(string $pathname)
    {
        $this->pathname = $pathname;
        $this->message  = "Root directory '$pathname' is not readable";
    }

    public function getPathname(): string
    {
        return $this->pathname;
    }
}
