<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Service;

use PHPUnit\Framework\TestCase;

/**
 * @group  example
 */
class QuxTest extends TestCase
{
    public function testInvoke(): void
    {
        $this->assertEquals('qux', (new Qux())());

        return;
    }
}
