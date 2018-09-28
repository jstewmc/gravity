<?php
/**
 * The file for the factory interface
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\Manager;

/**
 * The factory interface
 *
 * @since  0.1.0
 */
interface Factory
{
    /**
     * Called when the factory is treated like a function
     *
     * @param   Manager  $g  the Gravity manager
     * @return  object
     * @since   0.1.0
     */
    public function __invoke(Manager $g): object;
}
