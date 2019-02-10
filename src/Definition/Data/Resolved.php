<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIt
 */

namespace Jstewmc\Gravity\Definition\Data;

use Jstewmc\Gravity\Id\Data as Id;

class Resolved extends Definition
{
    public function __construct(Id\Id $key, $value = null)
    {
        parent::__construct($key, $value);
    }

    public function getKey(): Id\Id
    {
        return parent::getKey();
    }

    // delegate method
    public function getSegments(): array
    {
        return $this->key->getSegments();
    }

    public function isService()
    {
        return $this->key instanceof Id\Service;
    }

    public function isSetting(): bool
    {
        return $this->key instanceof Id\Setting;
    }
}
