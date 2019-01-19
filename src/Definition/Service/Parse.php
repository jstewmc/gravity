<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Service;

use Jstewmc\Gravity\Definition\Data\{Parsed, Read};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;

class Parse
{
    private $parsePath;

    public function __construct(ParsePath $parsePath)
    {
        $this->parsePath = $parsePath;
    }

    public function __invoke(Read $definition): Parsed
    {
        $key = $this->parsePath($definition->getKey());

        $definition = new Parsed($key, $definition->getvalue());

        return $definition;
    }

    private function parsePath(string $path): Path
    {
        return ($this->parsePath)($path);
    }
}
