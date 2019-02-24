<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Data;

use Jstewmc\Gravity\Id\Data\Service as Id;

class Newable extends Service
{
    public function __construct(Id $id)
    {
        parent::__construct($id, null);
    }

    public function getClassname(): string
    {
        return implode('\\', $this->id->getSegments());
    }
}
