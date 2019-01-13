<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Alias\Exception\TypeMismatch;
use Jstewmc\Gravity\Id\Data\Id;

class Resolved extends Alias
{
    public function __construct(Id $source, Id $destination)
    {
        parent::__construct($source, $destination);
    }

    public function getDestination(): Id
    {
        return parent::getDestination();
    }

    public function getSource(): Id
    {
        return parent::getSource();
    }
}
