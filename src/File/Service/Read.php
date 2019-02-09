<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\File\Service;

use Jstewmc\Gravity\File\Data\Opened;

class Read
{
    public function __invoke(Opened $file): Opened
    {
        $g = $file;

        include $file->getPathname();

        return $file;
    }
}
