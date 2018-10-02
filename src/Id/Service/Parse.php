<?php
/**
 * The file for the parse-identifier service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Id\Data\Service;
use Jstewmc\Gravity\Id\Data\Setting;
use Jstewmc\Gravity\Id\Exception\BadLength;
use Jstewmc\Gravity\Id\Exception\BadSeparator;

/**
 * Parses an identifier
 *
 * @since  0.1.0
 */
class Parse
{
    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @param   string $id the identifier to parse
     * @return  Id
     * @since   0.1.0
     */
    public function __invoke(string $id): Id
    {
        $separator = $this->getSeparator($id);

        $segments = $this->getSegments($id, $separator);

        if ($separator === Service::SEPARATOR) {
            $id = new Service($segments);
        } else {
            $id = new Setting($segments);
        }

        return $id;
    }


    /* !Private methods */

    /**
     * Downcases an identifier
     *
     * @param   string $id the identifier to downcase
     * @return  string
     * @since   0.1.0
     */
    private function downcase(string $id): string
    {
        return strtolower($id);
    }

    /**
     * Explodes the identifier into segments, removing empties
     *
     * @param   string $id        the identifier to explode
     * @param   string $separator the identifier's separator
     * @return  string[]
     * @since   0.1.0
     */
    private function explode(string $id, string $separator): array
    {
        return array_values(array_filter(explode($separator, $id)));
    }

    /**
     * Returns the identifier's segments
     *
     * @param   string $id        the identifier
     * @param   string $separator the identifier's separator
     * @return  string[]
     * @throws  BadLength  if $id has too few segments
     * @since   0.1.0
     */
    private function getSegments(string $id, string $separator): array
    {
        $id = $this->trim($id);
        $id = $this->downcase($id);
        $id = $this->popSeparator($id, $separator);
        $id = $this->shiftSeparator($id, $separator);

        $segments = $this->explode($id, $separator);

        if (count($segments) < 3) {
            throw new BadLength($id);
        }

        return $segments;
    }

    /**
     * Returns the identifier's separator
     *
     * @param   string $id the identifier to test
     * @return  string
     * @throws  BadSeparator  if $id doesn't contain valid separator
     * @since   0.1.0
     */
    private function getSeparator(string $id): string
    {
        $separator = null;

        if (strpos($id, Service::SEPARATOR) !== false) {
            $separator = Service::SEPARATOR;
        } elseif (strpos($id, Setting::SEPARATOR) !== false) {
            $separator = Setting::SEPARATOR;
        } else {
            throw new BadSeparator($id);
        }

        return $separator;
    }

    /**
     * Pops a trailing separator off the end of the separator, if it exists
     *
     * @param   string $id        the identifier
     * @param   string $separator the identifier's separator
     * @return  string
     * @since   0.1.0
     */
    private function popSeparator(string $id, string $separator): string
    {
        if (substr($id, -1) === $separator) {
            $id = substr($id, 0, -1);
        }

        return $id;
    }

    /**
     * Shifts a leading separator off the front of the identifier, if it exists
     *
     * @param   string $id        the identifier
     * @param   string $separator the identifier's separator
     * @return  string
     * @since   0.1.0
     */
    private function shiftSeparator(string $id, string $separator): string
    {
        if (substr($id, 0, 1) === $separator) {
            $id = substr($id, 1);
        }

        return $id;
    }

    /**
     * Trims leading- and trailing-spaces
     *
     * @param   string $id the identifier to trim
     * @return  string
     * @since   0.1.0
     */
    private function trim(string $id): string
    {
        return trim($id);
    }
}
