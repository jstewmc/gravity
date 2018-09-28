<?php
/**
 * The file for the "not foun" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Exception;

/**
 * Thrown when a pathname does not exist
 *
 * @since  0.1.0
 */
class NotFound extends Filesystem
{
    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  string  $pathname
     * @since  0.1.0
     */
    public function __construct(string $pathname)
    {
        parent::__construct($pathname);

        $this->message = "'$pathname' does not exist";
    }
}
