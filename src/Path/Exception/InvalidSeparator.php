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

        $message = "Service (". Service::$separator .") or setting ("
            . Setting::$separator .") separator missing from path '$path'";

        parent::__construct($message);
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
