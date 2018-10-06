<?php
/**
 * The file for the example "quux" service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

/**
 * The example "quux" service
 *
 * @since  0.1.0
 */
class Quux
{
    public function __invoke(): string
    {
        return 'quux';
    }
}
