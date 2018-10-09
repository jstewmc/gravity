<?php
/**
 * The file for a hash-based array
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Data;

use Jstewmc\Gravity\Cache\Exception\NotFound;

/**
 * A simple hash-based cache
 *
 * @since  0.1.0
 */
class Hash implements Cache
{
    /* !Private properties */

    /**
     * @var    mixed  the cached values indexed by identifier
     * @since  0.1.0
     */
    private $values = [];


    /* !Public methods */

    /**
     * Resets the cache
     *
     * @return  bool
     * @since   0.1.0
     */
    public function clear(): bool
    {
        $this->values = [];

        return true;
    }

    /**
     * Removes a value from the cache
     *
     * @param   string  $key  the key of the cached item to delete
     * @return  bool
     * @since   0.1.0
     */
    public function delete(string $key): bool
    {
        if ($this->has($key)) {
            unset($this->values[$key]);
        }

        return true;
    }

    /**
     * Returns the cached value
     *
     * @param   string  $key  the key of the cached item to get
     * @return  mixed
     * @throws  NotFound  if $key does not exist
     * @since   0.1.0
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            throw new NotFound($key);
        }

        return $this->values[$key];
    }

    /**
     * Returns true if the value is cached
     *
     * @param   string  $key  the key of the cached item
     * @return  bool
     * @since   0.1.0
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->values);
    }

    /**
     * Caches a value
     *
     * @param   string  $key    the key to cache
     * @param   mixed   $value  the value to cache
     * @return  bool
     * @since   0.1.0
     */
    public function set(string $key, $value): bool
    {
        $this->values[$key] = $value;

        return true;
    }
}
