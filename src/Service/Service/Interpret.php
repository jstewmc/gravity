<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Closure;
use Jstewmc\Gravity\Definition\Data\Resolved as Definition;
use Jstewmc\Gravity\Factory as FactoryInterface;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Service\Data\{Factory, Fx, Instance, Newable, Service};
use Jstewmc\Gravity\Service\Exception\InvalidDefinition;

/**
 * Interprets definitions into concrete service types (e.g., fx, factory, etc).
 */
class Interpret
{
    public function __invoke(Definition $definition, Ns $namespace): Service
    {
        $key   = $definition->getKey();
        $value = $definition->getValue();

        if ($this->isFunction($value)) {
            $service = new Fx($key, $value, $namespace);
        } elseif ($this->isFactory($value)) {
            $service = new Factory($key, $value);
        } elseif ($this->isInstance($value)) {
            $service = new Instance($key, $value);
        } elseif ($this->isNewable($value)) {
            $service = new Newable($key, $value);
        } else {
            throw new InvalidDefinition($definition);
        }

        return $service;
    }

    private function isFunction($value): bool
    {
        // verify instanceof Closure, because is_callable() will return true if
        // an object implements __invoke()
        return is_callable($value) && $value instanceof Closure;
    }

    private function isFactory($value): bool
    {
        // use class_exists and is_subclass_of, because instanceof operator does
        // not accept strings
        return is_string($value)
            && class_exists($value)
            && is_subclass_of($value, FactoryInterface::class);
    }

    private function isInstance($value): bool
    {
        return is_object($value);
    }

    private function isNewable($value): bool
    {
        return is_null($value);
    }
}
