<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\File\Data\{Parsed, Ran};
use Jstewmc\Gravity\Script\Service\{Interpret, Resolve};

class Run
{
    private $interpret;

    private $resolve;

    public function __construct(Resolve $resolve, Interpret $interpret)
    {
        $this->resolve   = $resolve;
        $this->interpret = $interpret;
    }

    public function __invoke(Parsed $file): Ran
    {
        $script = ($this->resolve)($file->getScript(), $file->getNamespace());
        $script = ($this->interpret)($script, $file->getNamespace());

        $file = new Ran($file->getPathname(), $file->getNamespace(), $script);

        return $file;
    }
}
