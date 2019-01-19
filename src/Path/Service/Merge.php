<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Path\Data\{Path, Service, Setting};
use Jstewmc\Gravity\Path\Exception\TypeMismatch;

class Merge
{
    public function __invoke(Path $a, Path $b): Path
    {
        if (!($a instanceof $b)) {
            throw new TypeMismatch($a, $b);
        }

        $segments = array_merge($a->getSegments(), $b->getSegments());

        if ($a instanceof Service) {
            $path = new Service($segments);
        } else {
            $path = new Setting($segments);
        }

        return $path;
    }
}
