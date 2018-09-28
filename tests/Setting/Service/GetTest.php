<?php
/**
 * The file for the get-setting tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Project\Data\Project;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the get-setting service
 *
 * @since  0.1.0
 */
class GetTest extends TestCase
{
    // hmm, we could mock or stub, but does it matter?
    public function testInvoke(): void
    {
        $value = true;

        $id = $this->createMock(Id::class);

        $project = $this->createMock(Project::class);
        $project->method('getSetting')->willReturn($value);

        $sut = new Get();

        $this->assertEquals($value, $sut($id, $project));

        return;
    }
}
