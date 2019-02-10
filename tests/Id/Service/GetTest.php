<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\{Id, Ns, Project};
use PHPUnit\Framework\TestCase;

class GetTest extends TestCase
{
    public function testInvoke()
    {
        $id = $this->createMock(Id\Data\Id::class);

        $render = $this->createMock(Render::class);
        $render->method('__invoke')->willReturn($id);

        $follow = $this->createMock(Follow::class);
        $follow->method('__invoke')->willReturn($id);

        $sut = new Get($render, $follow);

        $path      = 'foo.bar.baz';
        $namespace = $this->createMock(Ns\Data\Parsed::class);
        $project   = $this->createMock(Project\Data\Project::class);

        $expected = $id;
        $actual   = $sut($path, $namespace, $project);

        $this->assertEquals($expected, $actual);
    }
}
