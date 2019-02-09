<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Service;

use PHPUnit\Framework\TestCase;

/**
 * @group  root
 */
class FindTest extends TestCase
{
    public function testInvokeReturnsPackageDirectoryIfNotComposer(): void
    {
        $expected = realpath(dirname(__FILE__, 4));
        $actual   = (new Find('vendor'))();

        $this->assertEquals($expected, $actual);

        return;
    }

    // public function testInvokeReturnsProjectDirectoryIfComposer(): void
    // {
    //     // hmm, how the heck do I test this?!
    // }
}
