<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Data;

use SplFileInfo;

abstract class Filesystem
{
    /**
     * @var  SplFileInfo[]
     */
    private $files = [];

    public function __construct(array $files)
    {
        $this->files = $files;
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}
