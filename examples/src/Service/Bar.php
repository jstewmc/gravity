<?php
/**
 * The file for the example "bar" service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

/**
 * The example "bar" service
 *
 * @since  0.1.0
 */
class Bar
{
    public function __invoke(): string
    {
        return 'bar';
    }
}
