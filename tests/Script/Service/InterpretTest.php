<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Script\Data\{Interpreted, Resolved};
use Jstewmc\Gravity\Service\Service\Interpret as InterpretService;
use Jstewmc\Gravity\Setting\Service\Interpret as InterpretSetting;
use PHPUnit\Framework\TestCase;

class InterpretTest extends TestCase
{
    public function testInvoke(): void
    {
        $interpretService = $this->createMock(InterpretService::class);
        $interpretSetting = $this->createMock(InterpretSetting::class);

        $sut = new Interpret($interpretService, $interpretSetting);

        $expected = new Interpreted();
        $actual   = $sut(new Resolved(), new Ns());

        $this->assertEquals($expected, $actual);
    }
}
