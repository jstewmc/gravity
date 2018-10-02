<?php
/**
 * The file for an instance-defined service
 *
 * @author     Jack Clayton <claysj0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;

/**
 * An instance-defined service
 *
 * @since  0.1.0
 */
class Instance extends Service
{
    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  Id  $id  the service's identifier
     * @param  object      $definition  the service's definition
     * @since  0.1.0
     */
    public function __construct(Id $id, object $definition)
    {
        parent::__construct($id, $definition);
    }


    /* !Get methods */

    /**
     * Returns the service's definition
     *
     * @return  object
     * @since   0.1.0
     */
    public function getDefinition(): object
    {
        return parent::getDefinition();
    }
}
