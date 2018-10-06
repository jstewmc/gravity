<?php
/**
 * The file for the example "baz" service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

/**
 * The example "baz" service
 *
 * @since  0.1.0
 */
class Baz
{
    public function __invoke(): string
    {
        return 'baz';
    }
}
