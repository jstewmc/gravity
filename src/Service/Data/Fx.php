<?php
/**
 * The file for an anonymous-function-defined service
 *
 * @author     Jack Clayton <claysj0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;


/**
 * An anonymous-function-defined service
 *
 * @since  0.1.0
 */
class Fx extends Service
{
    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  Id  $id  the service's identifier
     * @param  Callable    $definition  the service's definition
     * @since  0.1.0
     */
    public function __construct(Id $id, Callable $definition)
    {
        parent::__construct($id, $definition);
    }


    /* !Get methods */

    /**
     * Returns the service's definition
     *
     * @return  Callable
     * @since   0.1.0
     */
    public function getDefinition(): Callable
    {
        return parent::getDefinition();
    }
}
