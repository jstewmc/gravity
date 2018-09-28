<?php
/**
 * The file for a setting alias
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Id\Data\Setting as Id;

/**
 * A setting alias
 *
 * @since  0.1.0
 */
class Setting extends Alias
{
    /* !Magic methods */

    /**
     * Called when the alias is constructed
     *
     * @param  Id  $source       the alias' source identifier
     * @param  Id  $destination  the alias' destination identifier
     * @since  0.1.0
     */
    public function __construct(Id $source, Id $destination)
    {
        parent::__construct($source, $destination);
    }
}
