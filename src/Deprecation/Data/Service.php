<?php
/**
 * The file for a service deprecation
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;

/**
 * A service deprecation
 *
 * @since  0.1.0
 */
class Service extends Deprecation
{
    /* !Magic methods */

    /**
     * Called when the deprecation is constructed
     *
     * @param  Id       $source       the deprecated identifier
     * @param  Id|null  $destination  the identifier's replacement (optional)
     * @since  0.1.0
     */
    public function __construct(
        Id $id,
        Id $replacement = null
    ) {
        parent::__construct($id, $replacement);
    }
}
