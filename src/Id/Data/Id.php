<?php
/**
 * The file for a setting or service identifier
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  Jack Clayton 2018
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

/**
 * Uniquely identifies a service or setting across the project
 * An identifier is composed of three or more case-insensitive segments (i.e., a
 * vendor name, a package name, and a path) separated by a separator character
 * (i.e., a backslash ("\") for services and period (".") for settings).
 *
 * @since  0.1.0
 */
abstract class Id
{
    /* !Public constants */

    /**
     * @var    string  the identifier's separator character (MUST be defined
     *     in each child class)
     * @since  0.1.0
     */
    public const SEPARATOR = '';

    /* !Private properties */

    /**
     * @var    string[]  the identifier's segments
     * @since  0.1.0
     */
    private $segments;

    /* !Magic methods */

    /**
     * Called when the identifier is constructed
     *
     * @param   string[] $segments the identifier's segments
     * @since   0.1.0
     */
    public function __construct(array $segments)
    {
        $this->segments = $segments;
    }

    /**
     * Called when the identifier is treated like a string
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
     * Returns the identifier's segments
     *
     * @return  string[]
     * @since   0.1.0
     */
    public function getSegments(): array
    {
        return $this->segments;
    }
}
