<?php
/**
 * The file for a "setting not found" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Exception;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Exception;

/**
 * Thrown when a setting is not found
 *
 * @since  0.1.0
 */
class NotFound extends Exception
{
    /* !Private properties */

    /**
     * @var    Id  the exception's identifier
     * @since  0.1.0
     */
    private $idenfifier;


    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  Id  $id
     * @since  0.1.0
     */
    public function __construct(Id $id)
    {
        $this->identifier = $id;

        $this->message = "Setting '$id' not found";
    }


    /* !Get methods */

    /**
     * Returns the exception's identifier
     *
     * @return  Id
     * @since   0.1.0
     */
    public function getId(): Id
    {
        return $this->identifier;
    }
}
