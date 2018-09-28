<?php
/**
 * The file for the parse-service service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\Factory as FactoryInterface;
use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Id\Service\Parse as ParseId;
use Jstewmc\Gravity\Service\Data\{Factory, Fx, Instance, Newable, Service};
use Jstewmc\Gravity\Service\Exception\BadDefinition;

/**
 * Parses a service definition
 *
 * @since  0.1.0
 */
class Parse
{
    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @param   Id  $id  the service's identifier
     * @param   mixed|null  $value       the service's definition (optional)
     * @return  Service
     * @throws  BadDefinition  if $value is invalid
     * @since   0.1.0
     */
    public function __invoke(Id $id, $value = null): Service
    {
        if ($this->isFunction($value)) {
            $service = new Fx($id, $value);
        } elseif ($this->isFactory($value)) {
            $service = new Factory($id, $value);
        } elseif ($this->isInstance($value)) {
            $service = new Instance($id, $value);
        } elseif ($this->isNewable($value)) {
            $service = new Newable($id, $value);
        } else {
            throw new BadDefinition($id, $value);
        }

        return $service;
    }


    /* !Private methods */

    /**
	 * Returns true if the service is an anonymous function
	 *
	 * @param   mixed  $value  the value to test
	 * @return  bool
	 * @since   0.1.0
	 */
	private function isFunction($value): bool
	{
		return is_callable($value);
	}

	/**
	 * Returns true if the service is a factory
	 *
	 * @param   mixed  $value  the value to test
	 * @return  bool
	 * @since   0.1.0
	 */
	private function isFactory($value): bool
	{
        // apparently, instanceof does not accept strings
		return is_string($value)
            && class_exists($value)
            && is_subclass_of($value, FactoryInterface::class);
	}

    /**
     * Returns true if the service is a service instance
     *
     * @param   mixed  $value  the value to test
     * @return  bool
     * @since   0.1.0
     */
    private function isInstance($value): bool
    {
        return is_object($value);
    }

    /**
     * Returns true if the service is a newable service
     *
     * @param   mixed  $value  the value to test
     * @return  bool
     * @since   0.1.0
     */
    private function isNewable($value): bool
    {
        return is_null($value);
    }
}
