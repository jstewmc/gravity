<?php
/**
 * The file for an newable-defined service
 *
 * @author     Jack Clayton <claysj0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;

/**
 * A newable-defined service
 *
 * @since  0.1.0
 */
class Newable extends Service
{
    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  Id  $id  the service's identifier
     * @since  0.1.0
     */
    public function __construct(Id $id)
    {
        parent::__construct($id, null);
    }


    /* !Get methods */

    /**
     * Returns the service's definition
     *
     * @return  null
     * @since   0.1.0
     */
    public function getDefinition(): void
    {
        return;
    }
}
