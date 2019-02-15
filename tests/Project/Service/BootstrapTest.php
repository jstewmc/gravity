<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Project\Service;

use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Root\Data\Root;
use PHPUnit\Framework\TestCase;
use Psr\Log;

class BootstrapTest extends TestCase
{
    public function testInvoke(): void
    {
        $root = $this->createMock(Root::class);

        $project = new Project($root);

        $logger = $this->createMock(Log\LoggerInterface::class);

        $sut = new Bootstrap();

        $this->assertSame($project, $sut($project, $logger));

        return;
    }
}
