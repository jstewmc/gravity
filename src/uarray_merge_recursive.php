<?php
/**
 * The file for the custom uarray_merge_recursive function
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

/**
 * Merges two arrays recursively
 *
 * PHP's native array_merge_recursive() merges values when the input arrays
 * have the same string keys. I'll replace the first value with the second.
 *
 * @example  PHP's native function
 *     $a = ["foo" => "bar"];
 *     $b = ["foo" => "baz"];
 *     array_merge_recursive($a, $b);  // returns ["foo" => ["bar","baz"]]
 *
 * @example  merge two arrays recursively
 *     $a = ["foo" => "bar"];
 *     $b = ["foo" => "baz"];
 *     $this->merge($a, $b);  // returns ["foo" => "baz"]
 *
 * @param   mixed[] $a the first array
 * @param   mixed[] $b the second array (takes precedence)
 * @return  mixed[]
 * @since    0.1.0
 * @see      http://php.net/manual/en/function.array-merge-recursive.php#92195
 *           gabriel dot sobrinho at gmail dot com's commnent on the
 *           array_merge_recursive() man page (accessed 11/26/17)
 */
function uarray_merge_recursive(array $a, array $b): array
{
    // loop through the second array
    foreach ($b as $k => $v) {
        // if the value is an array, the key exists in $a, and the value in
        // $a is an array, merge it recursively; otherwise, just set it in
        // $a
        if (is_array($v) && isset($a[$k]) && is_array($a[$k])) {
            $a[$k] = uarray_merge_recursive($a[$k], $v);
        } elseif (is_integer($k)) {
            $a[] = $v;
        } else {
            $a[$k] = $v;
        }
    }

    return $a;
}
