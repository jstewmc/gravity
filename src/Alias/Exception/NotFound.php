<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

use Jstewmc\Gravity\Id\Data\Id;

class NotFound extends Exception
{
    private $id;

    public function __construct(Id $id)
    {
        $this->id      = $id;
        $this->message = "Alias '$id' not found";
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
