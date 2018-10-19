<?php
/**
 * The file for the parse-setting service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Path\Data\Setting as Path;
use Jstewmc\Gravity\Setting\Data\Setting;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the parse-setting service
 *
 * @since  0.1.0
 */
class ParseTest extends TestCase
{
    public function testInvokeReturnsSettingIfValueIsScalar(): void
    {
        $value = 1;

        $path = $this->createMock(Path::class);
        $path->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

        $id = $this->createMock(Id::class);
        $id->method('getPath')->willReturn($path);

        $expected = new Setting(
            $id,
            [
                'foo' => [
                    'bar' => [
                        'baz' => $value
                    ],
                ],
            ]
        );
        $actual = (new Parse())($id, $value);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsSettingIfValueIsArray(): void
    {
        $value = [
            'qux' => [
                'quux' => 1
            ],
            'corge' => [
                'grault' => 2
            ]
        ];

        $path = $this->createMock(Path::class);
        $path->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

        $id = $this->createMock(Id::class);
        $id->method('getPath')->willReturn($path);

        $expected = new Setting(
            $id,
            [
                'foo' => [
                    'bar' => [
                        'baz' => $value
                    ],
                ],
            ]
        );
        $actual = (new Parse())($id, $value);

        $this->assertEquals($expected, $actual);

        return;
    }

    public function testInvokeReturnsSettingIfValueIsMixedCase(): void
    {
        // make sure the keys are downcased but values are preserved
        $value = ['QUX' => 'QUUX'];

        $path = $this->createMock(Path::class);
        $path->method('getSegments')->willReturn(['foo', 'bar', 'baz']);

        $id = $this->createMock(Id::class);
        $id->method('getPath')->willReturn($path);

        $expected = new Setting(
            $id,
            [
                'foo' => [
                    'bar' => [
                        'baz' => [
                            'qux' => 'QUUX'
                        ]
                    ],
                ],
            ]
        );
        $actual = (new Parse())($id, $value);

        $this->assertEquals($expected, $actual);

        return;
    }
}
