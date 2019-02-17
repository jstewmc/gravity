<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Path\Data\{Path, Service, Setting};
use Jstewmc\Gravity\Path\Exception\{EmptyPath, InvalidSeparator};

class Parse
{
    public function __invoke(string $path): Path
    {
        if ($path === '') {
            throw new EmptyPath();
        }

        if ($this->isService($path)) {
            $path = $this->parseService($path);
        } elseif ($this->isSetting($path)) {
            $path = $this->parseSetting($path);
        } else {
            throw new InvalidSeparator($path);
        }

        return $path;
    }


    /* !Private methods */

    private function lowercase(string $path): string
    {
        return strtolower($path);
    }

    private function explode(string $path, string $separator): array
    {
        return array_values(array_filter(explode($separator, $path)));
    }

    private function getSegments(string $path, string $separator): array
    {
        $path = $this->trim($path);
        $path = $this->lowercase($path);
        $path = $this->popSeparator($path, $separator);
        $path = $this->shiftSeparator($path, $separator);

        $segments = $this->explode($path, $separator);

        if (count($segments) === 0) {
            throw new EmptyPath();
        }

        return $segments;
    }

    private function hasLeadingSeparator(string $path, string $separator): bool
    {
        return substr($path, 0, 1) === $separator;
    }

    private function hasTrailingSeparator(string $path, string $separator): bool
    {
        return substr($path, -1) === $separator;
    }

    private function isService(string $path): bool
    {
        return strpos($path, Service::$separator) !== false;
    }

    private function isSetting(string $path): bool
    {
        return strpos($path, Setting::$separator) !== false;
    }

    private function parseService(string $path): Service
    {
        $hasLeadingSeparator = $this->hasLeadingSeparator(
            $path,
            Service::$separator
        );

        $hasTrailingSeparator = $this->hasTrailingSeparator(
            $path,
            Service::$separator
        );

        $path = (new Service($this->getSegments($path, Service::$separator)))
            ->setHasLeadingSeparator($hasLeadingSeparator)
            ->setHasTrailingSeparator($hasTrailingSeparator);

        return $path;
    }

    private function parseSetting(string $path): Setting
    {
        $hasLeadingSeparator = $this->hasLeadingSeparator(
            $path,
            Setting::$separator
        );

        $hasTrailingSeparator = $this->hasTrailingSeparator(
            $path,
            Setting::$separator
        );

        $path = (new Setting($this->getSegments($path, Setting::$separator)))
            ->setHasLeadingSeparator($hasLeadingSeparator)
            ->setHasTrailingSeparator($hasTrailingSeparator);

        return $path;
    }

    private function popSeparator(string $path, string $separator): string
    {
        if (substr($path, -1) === $separator) {
            $path = substr($path, 0, -1);
        }

        return $path;
    }

    private function shiftSeparator(string $path, string $separator): string
    {
        if (substr($path, 0, 1) === $separator) {
            $path = substr($path, 1);
        }

        return $path;
    }

    private function trim(string $path): string
    {
        return trim($path);
    }
}
