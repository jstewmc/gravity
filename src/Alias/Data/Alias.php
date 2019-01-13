<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

use Jstewmc\Gravity\Alias\Exception\Circular;

abstract class Alias
{
    private $destination;

    private $source;

    public function __construct($source, $destination)
    {
        if ($source == $destination) {
            throw new Circular($source);
        }

        $this->source      = $source;
        $this->destination = $destination;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function getSource()
    {
        return $this->source;
    }
}
