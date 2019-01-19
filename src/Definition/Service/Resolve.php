<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Service;

use Jstewmc\Gravity\Definition\Data\{Parsed, Resolved};
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

    public function __invoke(Parsed $definition, Ns $namespace): Resolved
    {
        $key = $this->resolvePath($definition->getKey(), $namespace);

        $definition = new Resolved($key, $definition->getvalue());

        return $definition;
    }

    private function resolvePath(Path $path, Ns $namespace): Id
    {
        return ($this->resolvePath)($path, $namespace);
    }
}
