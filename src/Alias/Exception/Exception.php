<?php
/**
 * The file for an alias exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

use Jstewmc\Gravity\Exception as GravityException;
use Jstewmc\Gravity\Id\Data\Id;

/**
 * An alias exception
 *
 * @since  0.1.0
 */
abstract class Exception extends GravityException
{
    /* !Private properties */

    /**
     * @var    Id  the exception's identifier
     * @since  0.1.0
     */
    private $id;


    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  Id  $id
     * @since  0.1.0
     */
    public function __construct(Id $id)
    {
        $this->identifier = $id;
    }


    /* !Get methods */

    /**
     * Returns the exception's identifier
     *
     * @return  Id
     * @since   0.1.0
     */
    public function getId(): Id
    {
        return $this->identifier;
    }
}
