<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Exception;

use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Exception;

class TooShort extends Exception
{
    private $path;

    public function __construct(Path $path)
    {
        $this->path = $path;

        $this->message = "Path '$path' contains less than three segments";
    }

    public function getPath(): Path
    {
        return $this->path;
    }
}
