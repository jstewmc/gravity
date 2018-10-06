<?php
/**
 * The file for the example "corge" service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

/**
 * The example "corge" service
 *
 * @since  0.1.0
 */
class Corge
{
    private $quuz;

    public function __construct(Quuz $quuz)
    {
        $this->quuz = $quuz;
    }

    public function __invoke(): string
    {
        return ($this->quuz)();
    }
}
