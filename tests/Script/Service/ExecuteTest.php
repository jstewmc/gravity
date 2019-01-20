<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Script\Data\Interpreted;
use PHPUnit\Framework\TestCase;

/**
 * @group  script
 */
class ExecuteTest extends TestCase
{
    public function testInvoke(): void
    {
        $script  = new Interpreted();
        $project = new Project();

        $sut = new Execute();

        $this->assertEquals($project, $sut($script, $project));

        return;
    }
}
