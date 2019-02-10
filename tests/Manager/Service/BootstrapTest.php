<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Manager\Service;

use Jstewmc\Gravity\{Id, Service, Setting};
use Jstewmc\Gravity\Cache\Data\Cache;
use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Project\Data\Project;
use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    public function testInvoke(): void
    {
        $project = $this->createMock(Project::class);

        $render      = $this->createMock(Id\Service\Render::class);
        $follow      = $this->createMock(Id\Service\Follow::class);
        $instantiate = $this->createMock(Service\Service\Instantiate::class);

        $cache = $this->createMock(Cache::class);
        $map   = [
            ['jstewmc\gravity\id\service\render', $render],
            ['jstewmc\gravity\id\service\follow', $follow],
            ['jstewmc\gravity\service\service\instantiate', $instantiate]
        ];
        $cache->method('get')->will($this->returnValueMap($map));

        $sut = new Bootstrap();

        $expected = new Manager(
            $project,
            new Id\Service\Get($render, $follow),
            new Service\Service\Get($instantiate, $cache),
            new Setting\Service\Get($cache)
        );
        $actual = $sut($project, $cache);

        $this->assertEquals($expected, $actual);
    }
}
