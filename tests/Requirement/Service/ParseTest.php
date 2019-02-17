<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Service;

use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;
use Jstewmc\Gravity\Requirement\Data\{Parsed, Read};
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    public function testInvoke(): void
    {
        // set up the path to return
        $key = $this->createMock(Path::class);
        $key->method('__toString')->willReturn('foo\bar\baz');

        // stub the parse-path service to return the stubs above
        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($key);

        // instantiate the system under test
        $sut = new Parse($parsePath);

        // stub a read requirement for input
        $description = 'foo';
        $validator   = function ($value) {
            return true;
        };

        $requirement = $this->createMock(Read::class);
        $requirement->method('getDescription')->willReturn($description);
        $requirement->method('getValidator')->willReturn($validator);

        // set expectations and get result
        $expected = new Parsed($key, $description, $validator);
        $actual   = $sut($requirement);

        $this->assertEquals($expected, $actual);

        return;
    }
}
