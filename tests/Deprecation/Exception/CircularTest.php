<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use PHPUnit\Framework\TestCase;

class CircularTest extends TestCase
{
    public function testGetValue(): void
    {
        $value = 'foo';

        $exception = new Circular($value);

        $this->assertEquals($value, $exception->getValue());

        return;
    }
}
