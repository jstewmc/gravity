<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Exception;

use Jstewmc\Gravity\Exception;

class NotFound extends Exception
{
    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;

        $this->message = "'$key' not cached";
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
