<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Import\Service;

use Jstewmc\Gravity\Import\Data\{Parsed, Read};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;

class Parse
{
    private $parsePath;

    public function __construct(ParsePath $parsePath)
    {
        $this->parsePath = $parsePath;
    }

    public function __invoke(Read $import): Parsed
    {
        $path = $this->parsePath($import->getPath());

        $name = $import->getName() ?: $path->getLastSegment();

        $import = new Parsed($path, $name);

        return $import;
    }

    private function parsePath(string $path): Path
    {
        return ($this->parsePath)($path);
    }
}
