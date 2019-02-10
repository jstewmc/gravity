<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Exception;

use Jstewmc\Gravity\Definition\Data\Resolved as Definition;

class InvalidDefinition extends Exception
{
    private $definition;

    public function __construct(Definition $definition)
    {
        $this->definition = $definition;
        $this->message    = "Invalid definition '{$definition->getKey()}'";
    }

    public function getDefinition(): Definition
    {
        return $this->definition;
    }
}
