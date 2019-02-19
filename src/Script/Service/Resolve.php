<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Alias\Service\Resolve as ResolveAlias;
use Jstewmc\Gravity\Definition\Service\Resolve as ResolveDefinition;
use Jstewmc\Gravity\Deprecation\Service\Resolve as ResolveDeprecation;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Requirement\Service\Resolve as ResolveRequirement;
use Jstewmc\Gravity\Script\Data\{Parsed, Resolved};

class Resolve
{
    private $resolveAlias;

    private $resolveDefinition;

    private $resolveDeprecation;

    private $resolveRequirement;

    public function __construct(
        ResolveAlias        $resolveAlias,
        ResolveDefinition   $resolveDefinition,
        ResolveDeprecation  $resolveDeprecation,
        ResolveRequirement  $resolveRequirement
    ) {
        $this->resolveAlias       = $resolveAlias;
        $this->resolveDefinition  = $resolveDefinition;
        $this->resolveDeprecation = $resolveDeprecation;
        $this->resolveRequirement = $resolveRequirement;
    }

    public function __invoke(Parsed $script, Ns $namespace): Resolved
    {
        $aliases = $this->resolveAliases(
            $script->getAliases(),
            $namespace
        );

        $definitions = $this->resolveDefinitions(
            $script->getDefinitions(),
            $namespace
        );

        $deprecations = $this->resolveDeprecations(
            $script->getDeprecations(),
            $namespace
        );

        $requirements = $this->resolveRequirements(
            $script->getRequirements(),
            $namespace
        );

        $script = (new Resolved())
            ->setAliases($aliases)
            ->setDefinitions($definitions)
            ->setDeprecations($deprecations)
            ->setRequirements($requirements);

        return $script;
    }

    private function resolveAliases(array $aliases, Ns $namespace): array
    {
        foreach ($aliases as &$alias) {
            $alias = ($this->resolveAlias)($alias, $namespace);
        }

        return $aliases;
    }

    private function resolveDefinitions(array $definitions, Ns $namespace): array
    {
        foreach ($definitions as &$definition) {
            $definition = ($this->resolveDefinition)($definition, $namespace);
        }

        return $definitions;
    }

    private function resolveDeprecations(array $deprecations, Ns $namespace): array
    {
        foreach ($deprecations as &$deprecation) {
            $deprecation = ($this->resolveDeprecation)($deprecation, $namespace);
        }

        return $deprecations;
    }

    private function resolveRequirements(array $requirements, Ns $namespace): array
    {
        foreach ($requirements as $requirement) {
            $requirement = ($this->resolveRequirement)($requirement, $namespace);
        }

        return $requirements;
    }
}
