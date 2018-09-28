<?php
/**
 * The file for a setting or service definition
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Data;

use Jstewmc\Gravity\Id\Data\Id;


/**
 * A setting or service definition
 *
 * Unlike aliases and deprecations which are more similar than different,
 * service and setting definitions are more different and have their own
 * directories.
 */
abstract class Definition
{
    /* !Private properties */

    /**
     * @var    Id  the definition's identifier
     * @since  0.1.0
     */
    private $id;


    /* !Magic methods */

    /**
     * Called when the definition is constructed
     *
     * @param  Id  $id  the definition's identifier
     * @since  0.1.0
     */
    public function __construct(Id $id)
    {
        $this->identifier = $id;
    }


    /* !Get methods */

    /**
     * Returns the definition's identifier
     *
     * @return  Id
     * @since   0.1.0
     */
    public function getId(): Id
    {
        return $this->identifier;
    }
}
