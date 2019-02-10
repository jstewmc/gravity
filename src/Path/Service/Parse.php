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
        if (strlen($path) === 0) {
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

    private function downcase(string $path): string
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
        $path = $this->downcase($path);
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
        return strpos($path, Service::SEPARATOR) !== false;
    }

    private function isSetting(string $path): bool
    {
        return strpos($path, Setting::SEPARATOR) !== false;
    }

    private function parseService(string $path): Service
    {
        $hasLeadingSeparator = $this->hasLeadingSeparator(
            $path,
            Service::SEPARATOR
        );

        $hasTrailingSeparator = $this->hasTrailingSeparator(
            $path,
            Service::SEPARATOR
        );

        $path = (new Service($this->getSegments($path, Service::SEPARATOR)))
            ->setHasLeadingSeparator($hasLeadingSeparator)
            ->setHasTrailingSeparator($hasTrailingSeparator);

        return $path;
    }

    private function parseSetting(string $path): Setting
    {
        $hasLeadingSeparator = $this->hasLeadingSeparator(
            $path,
            Setting::SEPARATOR
        );

        $hasTrailingSeparator = $this->hasTrailingSeparator(
            $path,
            Setting::SEPARATOR
        );

        $path = (new Setting($this->getSegments($path, Setting::SEPARATOR)))
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
