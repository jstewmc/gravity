<?php
/**
 * The file for the find-identifier tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Project\Data\Project;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the find-identifier service
 *
 * @since  0.1.0
 */
class FindTest extends TestCase
{
    public function testInvoke(): void
    {
        $id = $this->createMock(Id::class);

        $project = $this->createMock(Project::class);

        $parse = $this->createMock(Parse::class);
        $parse->method('__invoke')->willReturn($id);

        $resolve = $this->createMock(Resolve::class);
        $resolve->method('__invoke')->willReturn($id);

        $sut = new Find($parse, $resolve);

        $this->assertSame($id, $sut('foo', $project));

        return;
    }
}
