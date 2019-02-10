<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use Jstewmc\Gravity\File\Service\{Get, Run};
use Jstewmc\Gravity\Filesystem\Data\{Loaded, Traversed};

class Load
{
    private $get;

    private $run;

    public function __construct(Get $get, Run $run)
    {
        $this->get = $get;
        $this->run = $run;
    }

    public function __invoke(Traversed $filesystem): Loaded
    {
        $files = [];

        foreach ($filesystem->getFiles() as $file) {
            $file = ($this->get)($file);
            $file = ($this->run)($file);

            $files[] = $file;
        }

        return new Loaded($files);
    }
}
