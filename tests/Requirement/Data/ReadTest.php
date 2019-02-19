<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Data;

use PHPUnit\Framework\TestCase;

class ReadTest extends TestCase
{
    public function testGetDescription(): void
    {
        $description = 'bar';

        $requirement = new Read('foo', $description, function ($value) {
            return true;
        });

        $this->assertEquals($description, $requirement->getDescription());
    }

    public function testGetKey(): void
    {
        $key = 'foo';

        $requirement = new Read($key, 'bar', function ($value) {
            return true;
        });

        $this->assertEquals($key, $requirement->getKey());
    }

    public function testGetValidator(): void
    {
        $validator = function ($value) {
            return true;
        };

        $requirement = new Read('foo', 'bar', $validator);

        $this->assertEquals($validator, $requirement->getValidator());
    }
}
