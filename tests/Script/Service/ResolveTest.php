<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Alias\Service\Resolve as ResolveAlias;
use Jstewmc\Gravity\Definition\Service\Resolve as ResolveDefinition;
use Jstewmc\Gravity\Deprecation\Service\Resolve as ResolveDeprecation;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Script\Data\{Parsed, Resolved};
use PHPUnit\Framework\TestCase;

class ResolveTest extends TestCase
{
    public function testInvoke(): void
    {
        $resolveAlias       = $this->createMock(ResolveAlias::class);
        $resolveDefinition  = $this->createMock(ResolveDefinition::class);
        $resolveDeprecation = $this->createMock(ResolveDeprecation::class);

        $sut = new Resolve(
            $resolveAlias,
            $resolveDefinition,
            $resolveDeprecation
        );

        $this->assertEquals(new Resolved(), $sut(new Parsed(), new Ns()));
    }
}
