<?php
/**
 * The file for a "bad separator" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Exception;

use Jstewmc\Gravity\Id\Data\Service;
use Jstewmc\Gravity\Id\Data\Setting;

/**
 * Thrown when an identifier doesn't contain a valid separator
 *
 * @since  0.1.0
 */
class BadSeparator extends Exception
{
    /**
     * Called when the exception is constructed
     *
     * @param  string  $id  the invalid identifier
     * @since  0.1.0
     */
    public function __construct(string $id)
    {
        parent::__construct($id);

        $this->message = "Id '$id' does not contain a valid "
            . "valid service ('" . Service::SEPARATOR ."') or setting ('"
            . Setting::SEPARATOR . "') separator";
    }
}
