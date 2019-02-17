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
            $pathService = $this->parseService($path);
        } elseif ($this->isSetting($path)) {
			$pathService = $this->parseSetting($path);
        } else {
            throw new InvalidSeparator($path, '');
        }

        return $pathService;
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
        return strpos($path, Service::getSeparator()) !== false;
    }

    private function isSetting(string $path): bool
    {
        return strpos($path, Setting::getSeparator()) !== false;
    }

    private function parseService(string $path): Service
    {
		$separator 			  = Service::getSeparator();
        $hasLeadingSeparator  = $this->hasLeadingSeparator($path, $separator);
        $hasTrailingSeparator = $this->hasTrailingSeparator($path, $separator);

        return (new Service($this->getSegments($path, $separator)))
            ->setHasLeadingSeparator($hasLeadingSeparator)
            ->setHasTrailingSeparator($hasTrailingSeparator);
    }

    private function parseSetting(string $path): Setting
    {
		$separator 			  = Setting::getSeparator();
		$hasLeadingSeparator  = $this->hasLeadingSeparator($path, $separator);
		$hasTrailingSeparator = $this->hasTrailingSeparator($path, $separator);

        return (new Setting($this->getSegments($path, $separator)))
            ->setHasLeadingSeparator($hasLeadingSeparator)
            ->setHasTrailingSeparator($hasTrailingSeparator);
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
