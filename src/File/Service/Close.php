<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\File\Data\{Closed, Opened};
use Jstewmc\Gravity\Ns\Service\Close as CloseNamespace;
use Jstewmc\Gravity\Script\Service\Close as CloseScript;

class Close
{
    private $closeNamespace;

    private $closeScript;

    public function __construct(
        CloseNamespace  $closeNamespace,
        CloseScript     $closeScript
    ) {
        $this->closeNamespace = $closeNamespace;
        $this->closeScript    = $closeScript;
    }

    public function __invoke(Opened $file): Closed
    {
        $namespace = ($this->closeNamespace)($file->getNamespace());
        $script    = ($this->closeScript)($file->getScript());

        $file = new Closed($file->getPathname(), $namespace, $script);

        return $file;
    }
}
