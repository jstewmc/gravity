<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Definition\Data\Resolved as Definition;
use Jstewmc\Gravity\Setting\Data\Setting;

/**
 * Setting definitions have keys and values of arbitrary depth. Before they can
 * be merged, they must be standardized.
 */
class Interpret
{
    public function __invoke(Definition $definition): Setting
    {
        $array = $this->normalize($definition);
        $array = $this->downcase($array);

        $setting = new Setting($definition->getKey(), $array);

        return $setting;
    }

    /**
     * @see  https://stackoverflow.com/a/23299766  Mike Starov's answer to "How
     *  to convert all keys in a multi-dimensional array to snake_case?",
     *  StackOverflow (accessed 2017-12-29)
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
     * For example, the follwing key-value pairs...
     *
     *     1. "foo.bar.baz", "qux"
     *     2. "foo.bar", ["baz" => "qux"]
     *     3. "foo", ["bar" => ["baz" => "qux"]]
     *
     * ... should all normalize to the same array...
     *
     *     [
     *         "foo" => [
     *             "bar" => [
     *                 "baz" => "qux"
     *             ]
     *         ]
     *     ]
     */
    private function normalize(Definition $definition): array
    {
        $array = [];

        // get the identifier's segments
        // e.g., ["foo", "bar", "baz"]
        $segments = $definition->getSegments();

        // reverse them to innermost-to-outermost
        // e.g., ["foo", "bar", "baz"] -> ["baz", "bar", "foo"]
        $segments = array_reverse($segments);

        // unpack the definition's value
        $value = $definition->getValue();

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
