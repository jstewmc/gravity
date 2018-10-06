<?php
/**
 * The file for an example "foo" service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

/**
 * An example "foo" service
 *
 * @since  0.1.0
 */
class Foo
{
    public function __invoke(): string
    {
        return 'foo';
    }
}
