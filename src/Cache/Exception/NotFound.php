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

/**
 * Thrown when an identifier is not cached
 *
 * @since  0.1.0
 */
class NotFound extends Exception
{
    /* !Private properties */

    /**
     * @var    string  the cache key (i.e., identifier)
     * @since  0.1.0
     */
    private $key;


    /* !Private properties */

    /**
     * Called when the exception is constructed
     *
     * @param  string  $key  the key of the missing cached item
     * @since  0.1.0
     */
    public function __construct(string $key)
    {
        $this->key = $key;

        $this->message = "'$key' not cached";
    }


    /* !Get methods */

    /**
     * Returns the missing identifier
     *
     * @return  string
     * @since   0.1.0
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
