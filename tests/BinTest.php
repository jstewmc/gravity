<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

use PHPUnit\Framework\TestCase;

/**
 * Tests for Gravity's binary file.
 */
class BinTest extends TestCase
{
    public function testValidate(): void
    {
        $root = dirname(__FILE__, 2);

        $expected = "Project is valid!";
        $actual   = exec("{$root}/gravity validate");

        $this->assertEquals($expected, $actual);
    }
}
