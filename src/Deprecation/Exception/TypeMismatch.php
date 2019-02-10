<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use Jstewmc\Gravity\Path\Data\Path;

class TypeMismatch extends Exception
{
    private $source;

    private $replacement;

    public function __construct(Path $source, Path $replacement)
    {
        $this->source      = $source;
        $this->replacement = $replacement;
        $this->message     = "Replacement type (". get_class($replacement)
            .") does not match source type (". get_class($source) .")";
    }

    public function getReplacement(): Path
    {
        return $this->replacement;
    }

    public function getSource(): Path
    {
        return $this->source;
    }
}
