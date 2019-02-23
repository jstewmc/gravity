<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

use Jstewmc\Gravity\Id\Data\Id;
use Psr\Container\NotFoundExceptionInterface;

class NotFound extends Exception implements NotFoundExceptionInterface
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
