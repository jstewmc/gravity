<?php
/**
 * The file for a filesystem exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Exception;

use Jstewmc\Gravity\Exception;

/**
 * Thrown when a filesystem exception occurs
 *
 * @since  0.1.0
 */
abstract class Filesystem extends Exception
{
    /* !Private properties */

    /**
     * @var    string   the filesystem pathname
     * @since  0.1.0
     */
    private $pathname;


    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param   string  $pathname
     * @since  0.1.0
     */
    public function __construct(string $pathname)
    {
        $this->pathname = $pathname;
    }


    /* !Get methods */

    /**
     * Gets the filesystem pathname
     *
     * @return  string
     * @since   0.1.0
     */
    public function getPathname(): string
    {
        return $this->pathname;
    }
}
