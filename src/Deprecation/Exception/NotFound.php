<?php
/**
 * The file for the "deprecation not found" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use Jstewmc\Gravity\Id\Data\Id;

class NotFound extends Exception
{
    private $id;

    public function __construct(Id $id)
    {
        $this->id      = $id;
        $this->message = "Deprecation '$id' not found";
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
