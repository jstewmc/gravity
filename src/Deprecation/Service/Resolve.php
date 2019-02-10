<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\{Parsed, Resolved};
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Resolve as ResolvePath;

class Resolve
{
    private $resolvePath;

    public function __construct(ResolvePath $resolvePath)
    {
        $this->resolvePath = $resolvePath;
    }

    public function __invoke(Parsed $deprecation, Ns $namespace): Resolved
    {
        $source = $this->resolvePath($deprecation->getSource(), $namespace);

        if ($deprecation->hasReplacement()) {
            $replacement = $this->resolvePath($deprecation->getReplacement(), $namespace);
            $deprecation = new Resolved($source, $replacement);
        } else {
            $deprecation = new Resolved($source);
        }

        return $deprecation;
    }

    private function resolvePath(Path $path, Ns $namespace): Id
    {
        return ($this->resolvePath)($path, $namespace);
    }
}
