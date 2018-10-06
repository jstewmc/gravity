<?php
/**
 * The file for the example "quuz" service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

/**
 * The example "quuz" service
 *
 * @since  0.1.0
 */
class Quuz
{
    public function __invoke(): string
    {
        return 'quuz';
    }
}
