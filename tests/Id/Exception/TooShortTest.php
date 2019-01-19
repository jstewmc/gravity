<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Exception;

use Jstewmc\Gravity\Path\Data\Path;
use PHPUnit\Framework\TestCase;

/**
 * @group  id
 */
class TooShortTest extends TestCase
{
    public function testGetId(): void
    {
        $path = $this->createMock(Path::class);

        $this->assertSame($path, (new TooShort($path))->getPath());

        return;
    }
}
