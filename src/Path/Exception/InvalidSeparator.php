<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

use Jstewmc\Gravity\Path\Data\{Service, Setting};

class InvalidSeparator extends Exception
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;

        $this->message = "Service (". Service::SEPARATOR .") or setting ("
            . Setting::SEPARATOR .") separator missing from path '$path'";
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
