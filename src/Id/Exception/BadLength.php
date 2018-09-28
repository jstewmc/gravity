<?php
/**
 * The file for an "bad length" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Exception;

/**
 * Thrown when an identifier contains too few segments
 *
 * @since  0.1.0
 */
class BadLength extends Exception
{
    /**
     * Called when the exception is constructed
     *
     * @param  string    $id  the invalid identifier
     * @since  0.1.0
     */
    public function __construct(string $id)
    {
        parent::__construct($id);

        $this->message = "Id '$id' does not contain enough "
            . "segments (i.e., vendor, package, and path)";
    }
}
