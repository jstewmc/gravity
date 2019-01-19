<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Exception;

use Jstewmc\Gravity\Definition\Data\Resolved as Definition;
use Jstewmc\Gravity\Id\Data\Id;
use PHPUnit\Framework\TestCase;

/**
 * @group  service
 */
class InvalidDefinitionTest extends TestCase
{
    public function testGetDefinition(): void
    {
        $definition = $this->createMock(Definition::class);

        $exception = new InvalidDefinition($definition);

        $this->assertSame($definition, $exception->getDefinition());
    }
}
