<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

/**
 * @group  deprecation
 */
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
