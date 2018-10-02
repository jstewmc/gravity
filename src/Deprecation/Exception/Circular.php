<?php
/**
 * The file for a circular deprecation exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use Jstewmc\Gravity\Id\Data\Id;

/**
 * Thrown when an deprecation's identifier and replacement are the same
 *
 * @since  0.1.0
 */
class Circular extends Exception
{
    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  Id $id the deprecated identifier
     * @since  0.1.
     */
    public function __construct(Id $id)
    {
        parent::__construct($id);

        $this->message = "Cicular deprecation for '$id'";
    }
}
