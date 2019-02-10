<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Data;

use Jstewmc\Gravity\Cache\Exception\NotFound;

class Hash implements Cache
{
    private $values = [];

    public function clear(): bool
    {
        $this->values = [];

        return true;
    }

    public function delete(string $key): bool
    {
        if ($this->has($key)) {
            unset($this->values[$key]);
        }

        return true;
    }

    public function get(string $key)
    {
        if (!$this->has($key)) {
            throw new NotFound($key);
        }

        return $this->values[$key];
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->values);
    }

    public function set(string $key, $value): bool
    {
        $this->values[$key] = $value;

        return true;
    }
}
