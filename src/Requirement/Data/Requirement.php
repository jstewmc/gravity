<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Requirement\Data;

abstract class Requirement
{
    private $description;

    private $validator;

    protected $key;

    public function __construct($key, string $description, callable $validator)
    {
        $this->key         = $key;
        $this->description = $description;
        $this->validator   = $validator;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValidator(): ?callable
    {
        return $this->validator;
    }
}
