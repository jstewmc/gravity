<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Data;

use Jstewmc\Gravity\Cache\Exception\InvalidArgumentException;
use Psr\SimpleCache\CacheInterface;
use function array_key_exists;
use function count;
use function gettype;
use function is_object;
use function method_exists;

class Hash implements CacheInterface
{
    /** @var array */
    private $values = [];

    public function clear(): void
    {
        $this->values = [];
    }

    public function delete($key): void
    {
        $this->validateInput($key, 'string');

        if ($this->has($key)) {
            unset($this->values[(string)$key]);
        }
    }

    public function deleteMultiple($keys): void
    {
        $this->validateInput($keys, 'array');

        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    public function get($key, $default = null)
    {
        $this->validateInput($key, 'string');

        if (!$this->has($key)) {
            return $default;
        }

        return $this->values[(string)$key];
    }

    public function getMultiple($keys, $default = null): array
    {
        $this->validateInput($keys, 'array');

        $multiple = [];
        foreach ($keys as $key) {
            if ($get = $this->get($key)) {
                $multiple[] = $get;
            }

            unset($keys[$key]);
        }

        if (count($multiple) === 0) {
            return $default;
        }

        return $multiple;
    }

    public function has($key): bool
    {
        $this->validateInput($key, 'string');

        return array_key_exists((string)$key, $this->values);
    }

    public function set($key, $value, $ttl = null): void
    {
        $this->validateInput($key, 'string');

        $this->values[(string)$key] = $value;
    }

    public function setMultiple($values, $ttl = null): void
    {
        $this->validateInput($values, 'array');

        foreach ($values as $key => $value) {
            $this->set($key, $value);

            unset($values[$key]);
        }
    }

    /**
     * This method exists to validate input argument types since the PSR CacheInterface does not support them
     *
     * @see CacheInterface @throws tags
     *
     * @param mixed  $actual
     * @param string $expectedType
     */
    private function validateInput($actual, string $expectedType): void
    {
        if (is_object($actual)) {
            if (method_exists($actual, '__toString')) {
                return;
            }

            throw new InvalidArgumentException('string');
        }

        if (gettype($actual) !== $expectedType) {
            throw new InvalidArgumentException($expectedType);
        }
    }
}
