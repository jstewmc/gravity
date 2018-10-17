<?php
/**
 * The file for a service identifier
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

use Jstewmc\Gravity\Path\Data\Service as Path;

/**
 * A service identifier
 *
 * @since  0.1.0
 */
class Service extends Id
{
    /* !Magic methods */

    /**
     * Called when the id is constructed
     *
     * @param  Path  $path
     * @since  0.1.0
     */
    public function __construct(Path $path)
    {
        parent::__construct($path);
    }
}
