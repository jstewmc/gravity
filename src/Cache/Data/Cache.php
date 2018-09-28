<?php
/**
 * The file for a cache
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Data;

use Jstewmc\Gravity\Id\Data\Id;

/**
 * A simple cache interface
 *
 * @since  0.1.0
 */
interface Cache
{
    /* !Public methods */

    /**
     * Returns the cached value
     *
     * @param   Id  $id  the identifier to get
     * @return  mixed
     * @since   0.1.0
     */
    public function get(Id $id);

    /**
     * Returns true if the value is cached
     *
     * @param   Id  $id  the identifier to test
     * @return  bool
     * @since   0.1.0
     */
    public function has(Id $id): bool;

    /**
     * Removes a value from the cache if it exists
     *
     * @param   Id  the identifier to remove
     * @return  void
     * @since   0.1.0
     */
    public function remove(Id $id): void;

    /**
     * Resets the cache
     *
     * @return  void
     * @since   0.1.0
     */
    public function reset(): void;

    /**
     * Caches a value
     *
     * @param   Id  $id  the identifier to cache
     * @param   mixed       $value       the value to cache
     * @return  self
     * @since   0.1.0
     */
    public function set(Id $id, $value): Cache;
}
