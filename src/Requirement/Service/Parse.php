<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Service;

use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;
use Jstewmc\Gravity\Requirement\Data\{Parsed, Read};

class Parse
{
    private $parsePath;

    public function __construct(ParsePath $parsePath)
    {
        $this->parsePath = $parsePath;
    }

    public function __invoke(Read $requirement): Parsed
    {
        $key = $this->parsePath($requirement->getKey());

        $requirement = new Parsed(
            $key,
            $requirement->getDescription(),
            $requirement->getValidator()
        );

        return $requirement;
    }

    private function parsePath(string $path): Path
    {
        return ($this->parsePath)($path);
    }
}
