<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;

/**
 * A definition's _value_ becomes the service's _definition_.
 */
abstract class Service
{
    private $definition;

    protected $id;

    public function __construct(Id $id, $definition)
    {
        $this->id         = $id;
        $this->definition = $definition;
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function getId(): Id
    {
        return $this->id;
    }
}
