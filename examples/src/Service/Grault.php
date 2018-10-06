<?php
/**
 * The file for the example "grault" service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

/**
 * The example "grault" service
 *
 * @since  0.1.0
 */
class Grault
{
    public function __invoke(): string
    {
        return 'grault';
    }
}
