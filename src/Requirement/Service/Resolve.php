<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Service;

use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Resolve as ResolvePath;
use Jstewmc\Gravity\Requirement\Data\{Parsed, Resolved};

class Resolve
{
    private $resolvePath;

    public function __construct(ResolvePath $resolvePath)
    {
        $this->resolvePath = $resolvePath;
    }

    public function __invoke(Parsed $requirement, Ns $namespace): Resolved
    {
        $key = $this->resolvePath($requirement->getKey(), $namespace);

        $requirement = new Resolved(
            $key,
            $requirement->getDescription(),
            $requirement->getValidator()
        );

        return $requirement;
    }

    private function resolvePath(Path $path, Ns $namespace): Id
    {
        return ($this->resolvePath)($path, $namespace);
    }
}
