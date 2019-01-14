<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\{Parsed, Read};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;

class Parse
{
    private $parsePath;

    public function __construct(ParsePath $parsePath)
    {
        $this->parsePath = $parsePath;
    }

    public function __invoke(Read $deprecation): Parsed
    {
        $source = $this->parsePath($deprecation->getSource());

        if ($deprecation->hasReplacement()) {
            $replacement = $this->parsePath($deprecation->getReplacement());
            $deprecation = new Parsed($source, $replacement);
        } else {
            $deprecation = new Parsed($source);
        }

        return $deprecation;
    }

    private function parsePath(string $path): Path
    {
        return ($this->parsePath)($path);
    }
}
