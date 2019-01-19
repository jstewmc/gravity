<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;

class Factory extends Service
{
    public function __construct(Id $id, string $definition)
    {
        parent::__construct($id, $definition);
    }

    public function getDefinition(): string
    {
        return parent::getDefinition();
    }
}
