<?php
/**
 * @copyright  Jack Clayton 2018
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

use Jstewmc\Gravity\Id\Exception\TooShort;
use Jstewmc\Gravity\Path\Data\Path;

/**
 * Uniquely identifies a service or setting, using a path with three or more
 * segments - vendor, package, name[, ...] - to reduce collisions.
 */
abstract class Id
{
    private $path;

    public function __construct(Path $path)
    {
        if ($path->getLength() < 3) {
            throw new TooShort($path);
        }

        $this->path = $path;
    }

    public function __toString(): string
    {
        return strtolower((string)$this->path);
    }

    public function getPath(): Path
    {
        return $this->path;
    }

    // delegate method for getting path's segments
    public function getSegments(): array
    {
        return $this->path->getSegments();
    }
}
