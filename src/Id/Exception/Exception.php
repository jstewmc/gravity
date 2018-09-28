<?php
/**
 * The file for an "unparsable identifier" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Exception;

use Jstewmc\Gravity\Exception as GravityException;

/**
 * Thrown when an identifier cannot be parsed
 *
 * @since  0.1.0
 */
abstract class Exception extends GravityException
{
    /* !Private properties */

    /**
     * @var    string  the string identifier
     * @since  0.1.0
     */
    private $id;


    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  string  $id  the unparsable identifier
     * @since  0.1.0
     */
    public function __construct(string $id)
    {
        $this->identifier = $id;
    }


    /* !Get methods */

    /**
     * Returns the unparsable identifier
     *
     * @return  string
     * @since   0.1.0
     */
    public function getId(): string
    {
        return $this->identifier;
    }
}
