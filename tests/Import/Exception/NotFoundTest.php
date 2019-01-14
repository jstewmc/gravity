<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Import\Exception;

use PHPUnit\Framework\TestCase;

/**
 * @group  import
 */
class NotFoundTest extends TestCase
{
    public function testGetName(): void
    {
        $this->assertEquals('foo', (new NotFound('foo'))->getName());

        return;
    }
}
