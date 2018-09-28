<?php
/**
 * The file for a cache "not found" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Exception;

use Jstewmc\Gravity\Exception;
use Jstewmc\Gravity\Id\Data\Id;

/**
 * Thrown when an identifier is not cached
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
    private $id;

     
    /* !Private properties */

    /**
     * Called when the exception is constructed
     *
     * @param  Id  $id  the not found identifier
     * @since  0.1.0
     */
    public function __construct(Id $id)
    {
        $this->identifier = $id;

        $this->message = "'$id' not cached";
    }


    /* !Get methods */

    /**
     * Returns the missing identifier
     *
     * @return  Id
     */
    public function getId(): Id
    {
        return $this->identifier;
    }
}
