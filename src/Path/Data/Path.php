<?php
/**
 * @copyright  Jack Clayton 2018
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Data;

use Jstewmc\Gravity\Path\Exception\EmptyPath;
use function array_pop;
use function array_shift;
use function count;
use function end;
use function implode;
use function reset;

/**
 * Partial location of a service or setting in the project using one or more
 * segments, separated by a separator, with or without a leading- and trailing-
 * separator.
 */
abstract class Path
{
    private $hasLeadingSeparator = false;

    private $hasTrailingSeparator = false;

    private $segments;

    abstract public static function getSeparator(): string;

    public function __construct(array $segments)
    {
        if (count($segments) === 0) {
            throw new EmptyPath();
        }

        $this->segments = $segments;
    }

    public function __toString(): string
    {
        return implode($this::getSeparator(), $this->segments);
    }

    public function getFirstSegment(): string
    {
        return reset($this->segments);
    }

    public function getLastSegment(): string
    {
        return end($this->segments);
    }

    public function getLength(): int
    {
        return count($this->segments);
    }

    public function getSegments(): array
    {
        return $this->segments;
    }

    public function hasLeadingSeparator(): bool
    {
        return $this->hasLeadingSeparator;
    }

    public function hasTrailingSeparator(): bool
    {
        return $this->hasTrailingSeparator;
    }

    public function popSegment(): string
    {
        return array_pop($this->segments);
    }

    public function setHasLeadingSeparator(bool $hasLeadingSeparator): self
    {
        $this->hasLeadingSeparator = $hasLeadingSeparator;

        return $this;
    }

    public function setHasTrailingSeparator(bool $hasTrailingSeparator): self
    {
        $this->hasTrailingSeparator = $hasTrailingSeparator;

        return $this;
    }

    public function shiftSegment(): string
    {
        return array_shift($this->segments);
    }
}
