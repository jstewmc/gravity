<?php
/**
 * The file for a "bad path separator" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Exception;

use Jstewmc\Gravity\Path\Data\Service;
use Jstewmc\Gravity\Path\Data\Setting;

/**
 * Thrown when an path doesn't contain a valid separator
 *
 * @since  0.1.0
 */
class BadSeparator extends Exception
{
    /* !Private properties */

    /**
     * @var    string  the string path
     * @since  0.1.0
     */
    private $path;


    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  string  $path  the invalid path
     * @since  0.1.0
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        $this->message = "Path does not contain a service ("
            . Service::SEPARATOR . ") or setting (" . Setting::SEPARATOR
            . ") separator";
    }


    /* !Get methods */

    /**
     * Returns the unparsable path
     *
     * @return  string
     * @since   0.1.0
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
