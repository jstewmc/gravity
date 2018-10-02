<?php
/**
 * The file for the parse-setting service
 *
 * @author     Jack CLayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Setting\Data\Setting;

/**
 * Parses a setting definition
 *
 * Settings are defined as key-value pairs with both keys and values of
 * arbitrary length. However, before a setting can be merged into the project's
 * configuration array, it must be normalized into a single array.
 *
 * @since  0.1.0
 */
class Parse
{
    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @param   Id  $id  the setting's identifier
     * @param   mixed       $value       the setting's value (optional)
     * @return  Setting
     * @since   0.1.0
     */
    public function __invoke(Id $id, $value = null): Setting
    {
        $value = $this->toArray($id, $value);

        $value = $this->downcase($value);

        $setting = new Setting($id, $value);

        return $setting;
    }


    /* !Private methods */

    /**
     * Downcase an array's keys
     *
     * @example  lower-case the array keys
     *     $this->downcase(['FOO' => 'bar']);  // returns ['foo' => 'bar']
     * @param   array $array the array to downcase
     * @return  array
     * @since    0.1.0
     * @see      https://stackoverflow.com/a/23299766  Mike Starov's answer to
     *  "How to convert all keys in a multi-dimensional array to snake_case?"
     *  on Stack Overflow (accessed 2017-12-29)
     */
    private function downcase(array $array): array
    {
        return array_map(
            function ($item) {
                if (is_array($item)) {
                    $item = $this->downcase($item);
                }

                return $item;
            },
            array_change_key_case($array)
        );
    }

    /**
     * Converts a path and value into a single array
     * Settings are defined as key-value pairs, but they're stored in a single
     * consolidated array.
     * Ids can be of any length (e.g., "foo.bar" or "foo.bar.baz.quz"),
     * and values may be scalar or arrays of arbitrary depth (e.g., 1, "foo",
     * or ["foo" => "bar"]).
     * Before we can add a setting to a package's existing settings array, we
     * must normalize it to a standard array.
     * I'll normalize any identifier-value pair into an associative array so
     * they can be merged into the existing configuration set.
     *
     * @example  converting arbitrary identifier-value pairs (in pseudo-code)
     *     $a = $this->toArray("foo.bar.baz", "qux");
     *     $b = $this->toArray("foo.bar", ["baz" => "qux"]);
     *     $c = $this->toArray("foo", ["bar" => ["baz" => "qux"]]);
     *     $a === $b;  // returns true
     *     $b === $c;  // returns true
     * In the example above, $a, $b, and $c are equivalent to the following:
     *     [
     *         "foo" => [
     *             "bar" => [
     *                 "baz" => "qux"
     *             ]
     *         ]
     *     ]
     * @param   Id    $id    the setting's identifier
     * @param   mixed $value the setting's value
     * @return  array
     * @since    0.1.0
     */
    public function toArray(Id $id, $value): array
    {
        $array = [];

        // at this point, the identifier's segments are ordered from first-to-
        // last, left-to-right
        // e.g., ["foo", "bar", "baz"]
        //
        // reverse them from innermost to outermost
        // e.g., ["foo", "bar", "baz"] -> ["baz", "bar", "foo"]
        $segments = array_reverse($id->getSegments());

        // now, nest the values from the inside out
        // e.g., (i=0) ["baz" => $value]
        // e.g., (i=1) ["bar" => ["baz" => $value]]
        // e.g., (i=2) ["foo" => ["bar" => ["baz" => $value]]]
        foreach ($segments as $k => $segment) {
            $array[$segment] = $value;
            $value           = $array;
            $array           = [];
        }

        return $value;
    }
}
