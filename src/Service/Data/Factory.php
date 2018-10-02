<?php
/**
 * The file for a factory-defined service
 *
 * @author     Jack Clayton <claysj0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;

/**
 * A factory-defined service
 *
 * @since  0.1.0
 */
class Factory extends Service
{
    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  Id  $id  the service's identifier
     * @param  string      $definition  the service's definition
     * @since  0.1.0
     */
    public function __construct(Id $id, string $definition)
    {
        parent::__construct($id, $definition);
    }


    /* !Get methods */

    /**
     * Returns the service's definition
     *
     * @return  string
     * @since   0.1.0
     */
    public function getDefinition(): string
    {
        return parent::getDefinition();
    }
}
