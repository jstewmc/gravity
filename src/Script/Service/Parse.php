<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Alias\Service\Parse as ParseAlias;
use Jstewmc\Gravity\Definition\Service\Parse as ParseDefinition;
use Jstewmc\Gravity\Deprecation\Service\Parse as ParseDeprecation;
use Jstewmc\Gravity\Requirement\Service\Parse as ParseRequirement;
use Jstewmc\Gravity\Script\Data\{Closed, Parsed};

class Parse
{
    private $parseAlias;

    private $parseDefinition;

    private $parseDeprecation;

    public function __construct(
        ParseAlias        $parseAlias,
        ParseDefinition   $parseDefinition,
        ParseDeprecation  $parseDeprecation,
        ParseRequirement  $parseRequirement
    ) {
        $this->parseAlias       = $parseAlias;
        $this->parseDefinition  = $parseDefinition;
        $this->parseDeprecation = $parseDeprecation;
        $this->parseRequirement = $parseRequirement;
    }

    public function __invoke(Closed $script): Parsed
    {
        $aliases      = $this->parseAliases($script->getAliases());
        $definitions  = $this->parseDefinitions($script->getDefinitions());
        $deprecations = $this->parseDeprecations($script->getDeprecations());
        $requirements = $this->parseRequirements($script->getRequirements());

        $script = (new Parsed())
            ->setAliases($aliases)
            ->setDefinitions($definitions)
            ->setDeprecations($deprecations)
            ->setRequirements($requirements);

        return $script;
    }

    private function parseAliases(array $aliases): array
    {
        foreach ($aliases as &$alias) {
            $alias = ($this->parseAlias)($alias);
        }

        return $aliases;
    }

    private function parseDefinitions(array $definitions): array
    {
        foreach ($definitions as &$definition) {
            $definition = ($this->parseDefinition)($definition);
        }

        return $definitions;
    }

    private function parseDeprecations(array $deprecations): array
    {
        foreach ($deprecations as &$deprecation) {
            $deprecation = ($this->parseDeprecation)($deprecation);
        }

        return $deprecations;
    }

    private function parseRequirements(array $requirements): array
    {
        foreach ($requirements as &$requirement) {
            $requirement = ($this->parseRequirement)($requirement);
        }

        return $requirements;
    }
}
