<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Exception;

use Jstewmc\Gravity\Exception as GravityException;

abstract class Exception extends GravityException
{
    private $pathname;

    public function __construct(string $pathname)
    {
        $this->pathname = $pathname;
    }
    
    public function getPathname(): string
    {
        return $this->pathname;
    }
}
