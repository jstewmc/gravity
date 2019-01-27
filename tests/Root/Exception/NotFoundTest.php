<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @group  root
 */
class NotFoundTest extends TestCase
{
    public function testConstruct(): void
    {
        $this->assertInstanceOf(NotFound::class, new NotFound());
    }
}
