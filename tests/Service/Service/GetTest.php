<?php
/**
 * The file for the get-service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Service\Data\Service;
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * Tests for the get-service service
 *
 * @since  0.1.0
 */
class GetTest extends TestCase
{
    // hmm, I kind of mocked the whole method here
    public function testInvoke(): void
    {
        $id = $this->createMock(Id::class);

        $service = $this->createMock(Service::class);

        $instance = $this->createMock(StdClass::class);

        $project = $this->createMock(Project::class);
        $project->method('getService')->willReturn($service);

        $instantiate = $this->createMock(Instantiate::class);
        $instantiate->method('__invoke')->willReturn($instance);

        $sut = new Get($instantiate);

        $this->assertEquals($instance, $sut($id, $project));

        return;
    }
}
