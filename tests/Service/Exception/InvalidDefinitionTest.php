<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Exception;

use Jstewmc\Gravity\Definition\Data\Resolved as Definition;
use PHPUnit\Framework\TestCase;

class InvalidDefinitionTest extends TestCase
{
    public function testGetDefinition(): void
    {
        $definition = $this->createMock(Definition::class);

        $exception = new InvalidDefinition($definition);

        $this->assertSame($definition, $exception->getDefinition());
    }
}
