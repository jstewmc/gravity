<?php
/**
 * The file for the example "qux" service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

/**
 * The example "qux" service
 *
 * @since  0.1.0
 */
class Qux
{
    public function __invoke(): string
    {
        return 'qux';
    }
}
