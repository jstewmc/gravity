<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIt
 */

namespace Jstewmc\Gravity\Definition\Data;

use Jstewmc\Gravity\Id\Data as Id;

class Resolved extends Definition
{
    public function __construct(Id\Id $key)
    {
        parent::__construct($key);
    }

    public function getKey(): Id\Id
    {
        return parent::getKey();
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