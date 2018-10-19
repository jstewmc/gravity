<?php
/**
 * The file for a setting or service path
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  Jack Clayton 2018
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Data;

use Jstewmc\Gravity\Path\Exception\BadLength;

/**
 * A setting or service path
 *
 * A path is a full or partial location of a service or setting in the project.
 * A path is composed of one or more case-insensitive segments separated by a
 * character, which differs by type.
 *
 * @since  0.1.0
 */
abstract class Path
{
    /* !Private properties */

    /**
     * @var    string[]  the path's segments
     * @since  0.1.0
     */
    private $segments;


    /* !Magic methods */

    /**
     * Called when the path is constructed
     *
     * @param   string[]  $segments  the path's segments
     * @throws  BadLength  if $segments is empty
     * @since   0.1.0
     */
    public function __construct(array $segments)
    {
        if (!$segments) {
            throw new BadLength();
        }

        $this->segments = $segments;
    }

    /**
     * Called when the path is treated like a string
     *
     * @return  string
     * @since   0.1.0
     */
    public function __toString(): string
    {
        return implode(static::SEPARATOR, $this->segments);
    }


    /* !Get methods */

    /**
     * Returns the path's segments
     *
     * @return  string[]
     * @since   0.1.0
     */
    public function getSegments(): array
    {
        return $this->segments;
    }


    /* !Public methods */

    /**
     * Returns the path's length
     *
     * @return  int
     * @since   0.1.0
     */
    public function getLength(): int
    {
        return count($this->segments);
    }
}
