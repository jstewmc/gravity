<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Service;

use Jstewmc\Gravity\Alias\Data\{Parsed, Resolved};
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

    public function __invoke(Parsed $alias, Ns $namespace): Resolved
    {
        $source      = $this->resolvePath($alias->getSource(), $namespace);
        $destination = $this->resolvePath($alias->getDestination(), $namespace);

        $alias = new Resolved($source, $destination);

        return $alias;
    }

    private function resolvePath(Path $path, Ns $namespace): Id
    {
        return ($this->resolvePath)($path, $namespace);
    }
}
