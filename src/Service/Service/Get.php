<?php
/**
 * The file for the get-service service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Service\Data\Service;

/**
 * Returns a service from the project
 *
 * @since  0.1.0
 */
class Get
{
    /* !Private properties */

    /**
     * @var    Instantiate  the instantiate-service service
     * @since  0.1.0
     */
    private $instantiate;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  Instantiate  $instantiate  the instantiate-service service
     * @since  0.1.0
     */
    public function __construct(Instantiate $instantiate)
    {
        $this->instantiate = $instantiate;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   Id       $id       the service id
     * @param   Project  $project  the project
     * @return  object
     * @since   0.1.0
     */
    public function __invoke(Id $id, Project $project): object
    {
        $service = $project->getService($id);

        $instance = $this->instantiate($service);

        return $instance;
    }


    /* !Private methods */

    /**
     * Instantiates a Service
     *
     * @param   Service  $service  the service to instantiate
     * @return  object
     * @since   0.1.0
     */
    private function instantiate(Service $service): object
    {
        return ($this->instantiate)($service);
    }
}
