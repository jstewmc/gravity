<?php
/**
 * The file for a "bad definition" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Exception;

use Jstewmc\Gravity\Id\Data\Service as Id;

/**
 * Thrown when a service's definition is invalid
 *
 * @since  0.1.0
 */
class BadDefinition extends Exception
{
    /* !Private properties */

    /**
     * @var    mixed  the exception's definition
     * @since  0.1.0
     */
    private $definition;


    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  Id  $id  the service identifier
     * @param  mixed       $value       the invalid definition
     * @since  0.1.0
     */
    public function __construct(Id $id, $definition)
    {
        parent::__construct($id);

        $this->definition = $definition;

        $this->message = "'$id' definition invalid; anonymous "
            . "functions, factory implementations, object instances, and null "
            . "are accepted";
    }


    /* !Get methods */

    /**
     * Returns the exception's invalid definition
     *
     * @return  mixed
     * @since   0.1.0
     */
    public function getDefinition()
    {
        return $this->definition;
    }
}
