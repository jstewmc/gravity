<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\File\Exception\{NotFile, NotReadable};
use Jstewmc\Gravity\File\Data\Opened;
use Jstewmc\Gravity\Ns\Data\Opened as Ns;
use Jstewmc\Gravity\Script\Data\Opened as Script;

class Open
{
    public function __invoke($pathname): Opened
    {
        if (!is_readable($pathname)) {
            throw new NotReadable($pathname);
        }

        if (!is_file($pathname)) {
            throw new NotFile($pathname);
        }

        $file = new Opened($pathname, new Ns(), new Script());

        return $file;
    }
}
