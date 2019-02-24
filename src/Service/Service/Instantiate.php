<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Service\Data\{Factory, Fx, Instance, Newable, Service};

class Instantiate
{
    public function __invoke(Service $service, Manager $g): object
    {
        if ($service instanceof Fx) {
            $instance = $this->instantiateFx($service, $g);
        } elseif ($service instanceof Factory) {
            $instance = $this->instantiateFactory($service, $g);
        } elseif ($service instanceof Instance) {
            $instance = $this->instantiateInstance($service);
        } elseif ($service instanceof Newable) {
            $instance = $this->instantiateNewable($service);
        }

        return $instance;
    }


    public function instantiateFactory(Factory $service, Manager $g): object
    {
        $factory = $g->get($service->getDefinition());

        return $factory($g);
    }

    public function instantiateFx(Fx $service, Manager $g): object
    {
        $fx = $service->getDefinition();

        $g->enter($service->getNamespace());

        $fx = $fx->bindTo($g);

        $service = $fx();

        $g->exit();

        return $service;
    }

    public function instantiateInstance(Instance $service): object
    {
        return $service->getDefinition();
    }

    public function instantiateNewable(Newable $service): object
    {
        $classname = $service->getClassname();
        
        return new $classname;
    }
}
