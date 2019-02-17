<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

class InvalidSeparator extends Exception
{
    private $path;

    public function __construct(string $path, string $separator)
    {
        $this->path = $path;

        $message = 'Service (' . $separator . ') or setting ('
            . $separator .") separator missing from path '$path'";

        parent::__construct($message);
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
