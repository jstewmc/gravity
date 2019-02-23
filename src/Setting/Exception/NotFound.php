<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Exception;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Exception;
use Psr\Container\NotFoundExceptionInterface;

class NotFound extends Exception implements NotFoundExceptionInterface
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
