<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Exception;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Exception;

class NotFound extends Exception
{
    private $id;

    public function __construct(Id $id)
    {
        $this->id      = $id;
        $this->message = "Setting '$id' not found";
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
