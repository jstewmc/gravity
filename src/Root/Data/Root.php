<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Data;

use Jstewmc\Gravity\Root\Exception\{NotDirectory, NotReadable};
use SplFileInfo;

class Root extends SplFileInfo
{
    public function __construct(string $pathname)
    {
        if (!is_readable($pathname)) {
            throw new NotReadable($pathname);
        }

        if (!is_dir($pathname)) {
            throw new NotDirectory($pathname);
        }

        parent::__construct($pathname);
    }
}
