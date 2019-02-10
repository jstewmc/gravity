<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

use Jstewmc\Gravity\Path\Data\Path;

class TypeMismatch extends Exception
{
    private $source;

    private $destination;

    public function __construct(Path $source, Path $destination)
    {
        $this->source      = $source;
        $this->destination = $destination;

        $this->message = "Destination type (". get_class($destination)
            .") does not match source type (". get_class($destination) .")";
    }

    public function getDestination(): Path
    {
        return $this->destination;
    }

    public function getSource(): Path
    {
        return $this->source;
    }
}
