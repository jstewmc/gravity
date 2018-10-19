<?php
/**
 * The file for a setting or service identifier
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  Jack Clayton 2018
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

use Jstewmc\Gravity\Id\Exception\BadLength;
use Jstewmc\Gravity\Path\Data\Path as Path;

/**
 * Uniquely identifies a service or setting
 *
 * An identifier (aka, "id") is a path with three or more segments: vendor,
 * package, class, etc. Requiring three or more segments follows the PSR-4
 * convention and reduces the chances of a collision.
 *
 * @since  0.1.0
 */
abstract class Id
{
    /* !Private properties */

    /**
     * @var    Path  the identifier's path
     * @since  0.1.0
     */
    private $path;


    /* !Magic methods */

    /**
     * Called when the id is constructed
     *
     * @param   Path  $path  the idenfitier's path
     * @throws  BadLength  if the path is too short
     * @since   0.1.0
     */
    public function __construct(Path $path)
    {
        if ($path->getLength() < 3) {
            throw new BadLength($path);
        }

        $this->path = $path;
    }

    /**
     * Called when the id is treated like a string
     *
     * @return  string
     * @since   0.1.0
     */
    public function __toString(): string
    {
        return (string)$this->path;
    }


    /* !Get methods */

    /**
     * Returns the id's path
     *
     * @return  Path
     * @since   0.1.0
     */
    public function getPath(): Path
    {
        return $this->path;
    }
}
