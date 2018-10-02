<?php
/**
 * The file for the warn-deprecation service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\Service as Deprecation;
use Jstewmc\Gravity\Id\Data\Service as Id;
use PHPUnit\Framework\Error\Deprecated;
use PHPUnit\Framework\TestCase;

// either one

/**
 * Tests for the warn-deprecation service
 *
 * Keep in mind, based on our phpunit.xml settings, PHPUnit will convert
 * E_USER_DEPRECATED errors to PHPUnit\Framework\Error exceptions.
 *
 * @see    https://stackoverflow.com/a/1227686  jason's answer to "Test the
 *     return value of a method that triggers an error with PHPUnit" on
 *     StackOverflow (accessed 12/3/17)
 *
 * @since  0.1.0
 */
class WarnTest extends TestCase
{
    public function testInvokeTriggersErrorIfReplacementDoesNotExist(): void
    {
        $this->expectException(Deprecated::class);

        $id = $this->createMock(Id::class);

        $deprecation = new Deprecation($id);

        (new Warn())($deprecation);

        return;
    }

    public function testInvokeTriggersErrorIfReplacementDoesExist(): void
    {
        $this->expectException(Deprecated::class);

        $id          = $this->createMock(Id::class);
        $replacement = $this->createMock(Id::class);

        $deprecation = new Deprecation($id, $replacement);

        (new Warn())($deprecation);

        return;
    }
}
