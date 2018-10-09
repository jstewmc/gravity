<?php
/**
 * The file for a cache
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Data;

use Jstewmc\Gravity\Cache\Exception\NotFound;

/**
 * A simple cache interface
 *
 * This cache interface does its best to adhere to PSR-16, Common Interface for
 * Caching Libraries. However, the PSR does not support argument and return
 * types, and it adds multiple-item methods, TTL, and default values which are
 * unnecessary here.
 *
 * @since  0.1.0
 * @see    https://www.php-fig.org/psr/psr-16/  PSR-16: Common Interface for
 *     Caching Libraries (accessed 2018-10-08)
 */
interface Cache
{
    /**
     * Resets the cache
     *
     * @return  bool
     * @since   0.1.0
     */
    public function clear(): bool;

    /**
     * Removes a value from the cache if it exists
     *
     * @param   string  the key of the cached item to delete
     * @return  bool
     * @since   0.1.0
     */
    public function delete(string $key): bool;

    /**
     * Returns the cached value
     *
     * @param   string  $key  the key of the cached item to get
     * @return  mixed
     * @throws  NotFound  if $key does not exist
     * @since   0.1.0
     */
    public function get(string $key);

    /**
     * Returns true if the value is cached
     *
     * @param   string  $key  the key of the cached item
     * @return  bool
     * @since   0.1.0
     */
    public function has(string $key): bool;

    /**
     * Caches a value
     *
     * @param   string  $id     the identifier to cache
     * @param   mixed   $value  the value to cache
     * @return  bool
     * @since   0.1.0
     */
    public function set(string $key, $value): bool;
}
