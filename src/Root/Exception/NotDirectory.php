<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Exception;

class NotDirectory extends Exception
{
    private $pathname;

    public function __construct(string $pathname)
    {
        $this->pathname = $pathname;
        $this->message  = "'$pathname' is not a directory";
    }

    public function getPathname(): string
    {
        return $this->pathname;
    }
}
