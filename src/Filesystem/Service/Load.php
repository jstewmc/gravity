<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use Jstewmc\Gravity\File\Service\{Get, Run};
use Jstewmc\Gravity\Filesystem\Data\{Loaded, Traversed};
use Psr\Log\LoggerInterface;

class Load
{
    private $get;

    private $run;

    public function __construct(Get $get, Run $run, LoggerInterface $logger)
    {
        $this->get    = $get;
        $this->run    = $run;
        $this->logger = $logger;
    }

    public function __invoke(Traversed $filesystem): Loaded
    {
        $files = [];

        foreach ($filesystem->getFiles() as $file) {
            $this->logger->debug("Loading file {$file->getPathname()}...");

            $file = ($this->get)($file);
            $file = ($this->run)($file);

            $files[] = $file;
        }

        return new Loaded($files);
    }
}
