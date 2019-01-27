<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Data;

use PHPUnit\Framework\TestCase;

/**
 * @group  root
 */
class RootTest extends TestCase
{
    public function test(): void
    {
        // hmm, what do we test?
        $this->assertInstanceOf(Root::class, new Root('/path/to/foo'));
    }
}
