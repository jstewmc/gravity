<?php
/**
 * The file for the instantiate-service service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\Manager;
use Jstewmc\Gravity\Service\Data\{Factory, Fx, Instance, Newable, Service};

/**
 * Instantiates a service
 *
 * @since  0.1.0
 */
class Instantiate
{
    /* !Private properties */

    /**
     * @var    Manager  the Gravity manager
     * @since  0.1.0
     */
    private $g;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  Manager  $g  the Gravity manager
     * @since  0.1.0
     */
    public function __construct(Manager $g)
    {
        $this->g = $g;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   Service  $service  the service to instantiate
     * @return  object
     * @since   0.1.0
     */
    public function __invoke(Service $service): object
    {
        if ($service instanceof Fx) {
            $instance = $this->instantiateFx($service);
        } elseif ($service instanceof Factory) {
            $instance = $this->instantiateFactory($service);
        } elseif ($service instanceof Instance) {
            $instance = $this->instantiateInstance($service);
        } elseif ($service instanceof Newable) {
            $instance = $this->instantiateNewable($service);
        }

        return $instance;
    }


    /* !Private methods */

    /**
     * Instantiates an factory service
     *
     * @param   Factory  $service  the service to instantiate
     * @return  object
     * @since   0.1.0
     */
    public function instantiateFactory(Factory $service): object
    {
        $factory = $this->g->get($service->getDefinition());

        return $factory($this->g);
    }

    /**
     * Instantiates an anonymous function (aka, "fx") service
     *
     * @param   Fx  $service  the service to instantiate
     * @return  object
     * @since   0.1.0
     */
    public function instantiateFx(Fx $service): object
    {
        $fx = $service->getDefinition();

        $fx = $fx->bindTo($this->g);

        return $fx();
    }

    /**
     * Instantiates an instance service
     *
     * @param   Instance  $service  the service to instantiate
     * @return  object
     * @since   0.1.0
     */
    public function instantiateInstance(Instance $service): object
    {
        return $service->getDefinition();
    }

    /**
     * Instantiates a newable service
     *
     * @param   Newable  $service  the service to instantiate
     * @return  object
     * @since   0.1.0
     */
    public function instantiateNewable(Newable $service): object
    {
        $classname = (string) $service->getId();

        return new $classname;
    }
}
