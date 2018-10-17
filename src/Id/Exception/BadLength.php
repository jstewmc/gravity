<?php
/**
 * The file for an "bad id length" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Exception;

use Jstewmc\Gravity\Exception;

/**
 * Thrown when an id contains less than three segments
 *
 * @since  0.1.0
 */
class BadLength extends Exception
{
    /* !Private properties */

    /**
     * @var    string  the id's path
     * @since  0.1.0
     */
    private $path;


    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  string    $id  the id's path
     * @since  0.1.0
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        $this->message = "Path '$path' does not contain three or more segments";
    }


    /* !Get methods */

    /**
     * Returns the id's invalid path
     *
     * @return  string
     * @since   0.1.0
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
