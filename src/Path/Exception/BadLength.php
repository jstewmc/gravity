<?php
/**
 * The file for an "bad path length" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

/**
 * Thrown when a path is empty
 *
 * @since  0.1.0
 */
class BadLength extends Exception
{
    /**
     * Called when the exception is constructed
     *
     * @since  0.1.0
     */
    public function __construct()
    {
        $this->message = "Path is empty";
    }
}
