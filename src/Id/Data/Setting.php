<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

use Jstewmc\Gravity\Path\Data\Setting as Path;

class Setting extends Id
{
    public function __construct(Path $path)
    {
        parent::__construct($path);
    }
}
