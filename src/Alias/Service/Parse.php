<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Service;

use Jstewmc\Gravity\Alias\Data\{Parsed, Read};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;

class Parse
{
    private $parsePath;

    public function __construct(ParsePath $parsePath)
    {
        $this->parsePath = $parsePath;
    }

    public function __invoke(Read $alias): Parsed
    {
        $source      = $this->parsePath($alias->getSource());
        $destination = $this->parsePath($alias->getDestination());

        $alias = new Parsed($source, $destination);

        return $alias;
    }

    private function parsePath(string $path): Path
    {
        return ($this->parsePath)($path);
    }
}
