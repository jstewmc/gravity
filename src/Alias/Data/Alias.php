<?php
/**
 * The file for a setting or service alias
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Id\Data\Id;

/**
 * A setting or service alias
 *
 * In general, aliases should be discouraged. It's a better world if a single
 * identifier is sufficient to get a setting or service.
 *
 * @since  0.1.0
 */
abstract class Alias
{
    /* !Private properties */

    /**
     * @var    Id  the destination id
     * @since  0.1.0
     */
    private $destination;

    /**
     * @var    Id  the source id
     * @since  0.1.0
     */
    private $source;

    /* !Magic methods */

    /**
     * Called when the alias is constructed
     *
     * @param   Id $source      the source id
     * @param   Id $destination the destination id
     * @since   0.1.0
     */
    public function __construct(Id $source, Id $destination)
    {
        $this->source      = $source;
        $this->destination = $destination;
    }


    /* !Get methods */

    /**
     * Returns the alias' destination identifier
     *
     * @return  Id
     * @since   0.1.0
     */
    public function getDestination(): Id
    {
        return $this->destination;
    }

    /**
     * Returns the alias' source identifier
     *
     * @return  Id
     * @since   0.1.0
     */
    public function getSource(): Id
    {
        return $this->source;
    }
}
