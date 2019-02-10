<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Deprecation\Exception\Circular;

/**
 * Raises an E_USER_DEPRECATED error when requested.
 */
abstract class Deprecation
{
    private $source;

    protected $replacement;

    public function __construct($source, $replacement = null)
    {
        if ($source == $replacement) {
            throw new Circular($source);
        }

        $this->source      = $source;
        $this->replacement = $replacement;
    }

    public function getReplacement()
    {
        return $this->replacement;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function hasReplacement(): bool
    {
        return $this->replacement !== null;
    }
}
