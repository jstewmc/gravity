<?php
/**
 * The file for a service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Definition\Data\Definition;
use Jstewmc\Gravity\Id\Data\Service as Id;

/**
 * A service definition
 *
 * @since  0.1.0
 */
abstract class Service extends Definition
{
    /* !Private properties */

    /**
     * @var    mixed  the service's definition (e.g., closure, factory, etc)
     * @since  0.1.0
     */
    private $definition;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  Id  $id  the service's identifier
     * @param  mixed       $definition  the service's definition
     * @since  0.1.0
     */
    public function __construct(Id $id, $definition)
    {
        parent::__construct($id);

        $this->definition = $definition;
    }


    /* !Get methods */

    /**
     * Returns the service's definition
     *
     * @return  mixed
     * @since   0.1.0
     */
    public function getDefinition()
    {
        return $this->definition;
    }
}
