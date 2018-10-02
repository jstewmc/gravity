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
use Jstewmc\Gravity\Id\Data\Id;

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
     * Returns the cached value
     *
     * @param   Id  $id  the identifier to get
     * @return  mixed
     * @throws  NotFound  if $id does not exist
     * @since   0.1.0
     */
    public function get(Id $id)
    {
        if (!$this->has($id)) {
            throw new NotFound($id);
        }

        return $this->values[(string)$id];
    }

    /**
     * Returns true if the value is cached
     *
     * @param   Id  $id  the identifier to test
     * @return  bool
     * @since   0.1.0
     */
    public function has(Id $id): bool
    {
        return array_key_exists((string)$id, $this->values);
    }

    /**
     * Removes a value from the cache
     *
     * @param   Id  $id
     * @return  void
     * @since   0.1.0
     */
    public function remove(Id $id): void
    {
        if ($this->has($id)) {
            unset($this->values[(string)$id]);
        }

        return;
    }

    /**
     * Resets the cache
     *
     * @return  void
     * @since   0.1.0
     */
    public function reset(): void
    {
        $this->values = [];

        return;
    }

    /**
     * Caches a value
     *
     * @param   Id  $id  the identifier to cache
     * @param   mixed       $value       the value to cache
     * @return  self
     * @since   0.1.0
     */
    public function set(Id $id, $value): Cache
    {
        $this->values[(string)$id] = $value;

        return $this;
    }
}
