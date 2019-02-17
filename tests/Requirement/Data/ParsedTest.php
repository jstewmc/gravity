<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Data;

use Jstewmc\Gravity\Path\Data\Path;
use PHPUnit\Framework\TestCase;

class ParsedTest extends TestCase
{
    private $key;

    public function setUp()
    {
        $this->key = $this->createMock(Path::class);
    }

    public function testGetDescription(): void
    {
        $description = 'bar';

        $requirement = new Parsed($this->key, $description, function ($value) {
            return true;
        });

        $this->assertEquals($description, $requirement->getDescription());
    }

    public function testGetKey(): void
    {
        $requirement = new Parsed($this->key, 'bar', function ($value) {
            return true;
        });

        $this->assertSame($this->key, $requirement->getKey());
    }

    public function testGetValidator(): void
    {
        $validator = function ($value) {
            return true;
        };

        $requirement = new Parsed($this->key, 'bar', $validator);

        $this->assertEquals($validator, $requirement->getValidator());
    }
}
