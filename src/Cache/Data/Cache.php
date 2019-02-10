<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Data;

/**
 * A simple cache interface
 *
 * This cache interface does its best to adhere to PSR-16, Common Interface for
 * Caching Libraries. However, the PSR does not support argument and return
 * types, and it adds multiple-item methods, TTL, and default values which are
 * unnecessary here.
 *
 * @see    https://www.php-fig.org/psr/psr-16/  PSR-16: Common Interface for
 *     Caching Libraries (accessed 2018-10-08)
 */
interface Cache
{
    public function clear(): bool;

    public function delete(string $key): bool;

    public function get(string $key);

    public function has(string $key): bool;

    public function set(string $key, $value): bool;
}
