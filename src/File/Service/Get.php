<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\File\Data\Parsed;

class Get
{
    private $close;

    private $open;

    private $parse;

    private $read;

    public function __construct(Open $open, Read $read, Close $close, Parse $parse)
    {
        $this->open  = $open;
        $this->read  = $read;
        $this->close = $close;
        $this->parse = $parse;
    }

    public function __invoke(string $pathname): Parsed
    {
        $file = ($this->open)($pathname);
        $file = ($this->read)($file);
        $file = ($this->close)($file);
        $file = ($this->parse)($file);

        return $file;
    }
}
