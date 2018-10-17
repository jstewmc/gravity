<?php
/**
 * The file for the parse-path service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Data\Service;
use Jstewmc\Gravity\Path\Data\Setting;
use Jstewmc\Gravity\Path\Exception\BadLength;
use Jstewmc\Gravity\Path\Exception\BadSeparator;

/**
 * Parses a service or setting path
 *
 * @since  0.1.0
 */
class Parse
{
    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @param   string  $path  the path to parse
     * @return  Path
     * @throws  BadLength     if $path is blank (before or after parsing)
     * @throws  BadSeparator  if $path has invalid separator
     * @since   0.1.0
     */
    public function __invoke(string $path): Path
    {
        if (strlen($path) === 0) {
            throw new BadLength();
        }

        if ($this->isService($path)) {
            $path = $this->parseService($path);
        } elseif ($this->isSetting($path)) {
            $path = $this->parseSetting($path);
        } else {
            throw new BadSeparator($path);
        }

        return $path;
    }


    /* !Private methods */

    /**
     * Downcases an identifier
     *
     * @param   string $path the path to downcase
     * @return  string
     * @since   0.1.0
     */
    private function downcase(string $path): string
    {
        return strtolower($path);
    }

    /**
     * Explodes the path into segments, removing empties
     *
     * @param   string $path      the path to explode
     * @param   string $separator the path's separator
     * @return  string[]
     * @since   0.1.0
     */
    private function explode(string $path, string $separator): array
    {
        return array_values(array_filter(explode($separator, $path)));
    }

    /**
     * Returns the identifier's segments
     *
     * @param   string $path      the path
     * @param   string $separator the path's separator
     * @return  string[]
     * @throws  BadLength  if $path is empty
     * @since   0.1.0
     */
    private function getSegments(string $path, string $separator): array
    {
        $path = $this->trim($path);
        $path = $this->downcase($path);
        $path = $this->popSeparator($path, $separator);
        $path = $this->shiftSeparator($path, $separator);

        $segments = $this->explode($path, $separator);

        if (!$segments) {
            throw new BadLength();
        }

        return $segments;
    }

    /**
     * Returns true if the path is a service path
     *
     * @param   string  $path  the path to test
     * @return  bool
     * @since   0.1.0
     */
    private function isService(string $path): bool
    {
        return strpos($path, Service::SEPARATOR) !== false;
    }

    /**
     * Returns true if the path is a setting path
     *
     * @param   string  $path  the path to test
     * @return  bool
     * @since   0.1.0
     */
    private function isSetting(string $path): bool
    {
        return strpos($path, Setting::SEPARATOR) !== false;
    }

    /**
     * Parses a service path
     *
     * @param   string  $path  the path to parse
     * @return  Service
     * @since   0.1.0
     */
    private function parseService(string $path): Service
    {
        return new Service($this->getSegments($path, Service::SEPARATOR));
    }

    /**
     * Parses a setting path
     *
     * @param   string  $path  the path to parse
     * @return  Setting
     * @since   0.1.0
     */
    private function parseSetting(string $path): Setting
    {
        return new Setting($this->getSegments($path, Setting::SEPARATOR));
    }

    /**
     * Pops a trailing separator off the end of the path, if it exists
     *
     * @param   string $path      the path
     * @param   string $separator the paths separator
     * @return  string
     * @since   0.1.0
     */
    private function popSeparator(string $path, string $separator): string
    {
        if (substr($path, -1) === $separator) {
            $path = substr($path, 0, -1);
        }

        return $path;
    }

    /**
     * Shifts a leading separator off the front of the path, if it exists
     *
     * @param   string $id        the path
     * @param   string $separator the path's separator
     * @return  string
     * @since   0.1.0
     */
    private function shiftSeparator(string $path, string $separator): string
    {
        if (substr($path, 0, 1) === $separator) {
            $path = substr($path, 1);
        }

        return $path;
    }

    /**
     * Trims leading- and trailing-spaces
     *
     * @param   string $id the path to trim
     * @return  string
     * @since   0.1.0
     */
    private function trim(string $path): string
    {
        return trim($path);
    }
}
