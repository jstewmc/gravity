<?php
/**
 * The file for the "not readable" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Exception;

/**
 * Thrown when a pathname is not readable
 *
 * @since  0.1.0
 */
class NotReadable extends Filesystem
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

        $this->message = "'$pathname' is not readable";
    }
}
