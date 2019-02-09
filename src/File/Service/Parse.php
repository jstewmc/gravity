<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\File\Data\{Closed, Parsed};
use Jstewmc\Gravity\Ns\Service\Parse as ParseNamespace;
use Jstewmc\Gravity\Script\Service\Parse as ParseScript;

class Parse
{
    private $parseNamespace;

    private $parseScript;

    public function __construct(
        ParseNamespace  $parseNamespace,
        ParseScript     $parseScript
    ) {
        $this->parseNamespace = $parseNamespace;
        $this->parseScript    = $parseScript;
    }

    public function __invoke(Closed $file): Parsed
    {
        $namespace = ($this->parseNamespace)($file->getNamespace());
        $script    = ($this->parseScript)($file->getScript());

        $file = new Parsed($file->getPathname(), $namespace, $script);

        return $file;
    }
}
