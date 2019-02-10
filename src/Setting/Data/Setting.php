<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Data;

use Jstewmc\Gravity\Id\Data\Setting as Id;

class Setting
{
    private $array;

    private $id;

    public function __construct(Id $id, array $array)
    {
        $this->id    = $id;
        $this->array = $array;
    }

    public function getArray(): array
    {
        return $this->array;
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
