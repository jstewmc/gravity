<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Service;

use Jstewmc\Gravity\Import\Data as Import;
use Jstewmc\Gravity\Import\Service\Parse as ParseImport;
use Jstewmc\Gravity\Ns\Data\{Closed, Parsed};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;



class Parse
{
    private $parseImport;

    private $parsePath;

    public function __construct(ParsePath $parsePath, ParseImport $parseImport)
    {
        $this->parsePath   = $parsePath;
        $this->parseImport = $parseImport;
    }

    public function __invoke(Closed $namespace): Parsed
    {
        if ($namespace->hasName()) {
            $name = $this->parseNamespace($namespace->getName());
        }

        if ($namespace->hasImports()) {
            $imports = $this->parseImports($namespace->getImports());
        }

        $namespace = new Parsed();

        if (isset($name)) {
            $namespace->setName($name);
        }

        if (isset($imports)) {
            $namespace->setImports($imports);
        }

        return $namespace;
    }

    public function parseImport(Import\Read $import): Import\Parsed
    {
        return ($this->parseImport)($import);
    }

    private function parseImports(array $imports): array
    {
        foreach ($imports as &$import) {
            $import = $this->parseImport($import);
        }

        return $imports;
    }

    private function parseNamespace(string $namespace): Path
    {
        return ($this->parsePath)($namespace);
    }
}
