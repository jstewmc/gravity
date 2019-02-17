<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Service;

use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Path\Service\Resolve as ResolvePath;
use Jstewmc\Gravity\Requirement\Data\{Parsed, Resolved};
use PHPUnit\Framework\TestCase;

class ResolveTest extends TestCase
{
    public function testInvoke(): void
    {
        // stub the resolve-path service
        $key = $this->createMock(Id::class);
        $key->method('__toString')->willReturn('foo\bar\baz');

        $resolvePath = $this->createMock(ResolvePath::class);
        $resolvePath->method('__invoke')->willReturn($key);

        // instantiate the system under test
        $sut = new Resolve($resolvePath);

        // stub a parsed requirement for input
        $description = 'foo';
        $validator   = function ($value) {
            return true;
        };

        $requirement = $this->createMock(Parsed::class);
        $requirement->method('getDescription')->willReturn($description);
        $requirement->method('getValidator')->willReturn($validator);

        $expected = new Resolved($key, $description, $validator);
        $actual   = $sut($requirement, $this->createMock(Ns::class));

        $this->assertEquals($expected, $actual);

        return;
    }
}
