<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Alias\Service\Parse as ParseAlias;
use Jstewmc\Gravity\Definition\Service\Parse as ParseDefinition;
use Jstewmc\Gravity\Deprecation\Service\Parse as ParseDeprecation;
use Jstewmc\Gravity\Requirement\Service\Parse as ParseRequirement;
use Jstewmc\Gravity\Script\Data\{Closed, Parsed};
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    public function testInvoke(): void
    {
        $parseAlias       = $this->createMock(ParseAlias::class);
        $parseDefinition  = $this->createMock(ParseDefinition::class);
        $parseDeprecation = $this->createMock(ParseDeprecation::class);
        $parseRequirement = $this->createMock(ParseRequirement::class);

        $sut = new Parse(
            $parseAlias,
            $parseDefinition,
            $parseDeprecation,
            $parseRequirement
        );

        $this->assertEquals(new Parsed(), $sut(new Closed()));
    }
}
