<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

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
