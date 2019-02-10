<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Service;

use Jstewmc\Gravity\Import\Data as Import;
use Jstewmc\Gravity\Import\Service\Parse as ParseImport;
use Jstewmc\Gravity\Ns\Data\{Closed, Parsed};
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    public function testInvokeIfNameExists(): void
    {
        // set up parse-path dependency to return path
        $path = $this->createMock(Path::class);

        $parsePath = $this->createMock(ParsePath::class);
        $parsePath->method('__invoke')->willReturn($path);

        // set up parse-import dependency
        $parseImport = $this->createMock(ParseImport::class);

        // set up system-under-test
        $sut = new Parse($parsePath, $parseImport);

        // set up throwaway input
        $namespace = (new Closed())->setName('foo');

        // set up expectations
        $expected  = (new Parsed())->setName($path);
        $actual    = $sut($namespace);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeIfImportsExist(): void
    {
        // set up parse-import dependency
        $import = $this->createMock(Import\Parsed::class);

        $parseImport = $this->createMock(ParseImport::class);
        $parseImport->method('__invoke')->willReturn($import);

        // set up parse-path dependency
        $parsePath = $this->createMock(ParsePath::class);

        // set up system-under-test
        $sut = new Parse($parsePath, $parseImport);

        // set up throwaway input
        $input     = $this->createMock(Import\Read::class);
        $namespace = (new Closed())->setImports([$input]);

        // set up expectations
        $expected = (new Parsed())->setImports([$import]);
        $actual   = $sut($namespace);

        $this->assertEquals($expected, $actual);
    }
}
