<?php
/**
 * The file for the parse-deprecation service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\{
    Deprecation,
    Service as ServiceDeprecation,
    Setting as SettingDeprecation
};
use Jstewmc\Gravity\Deprecation\Exception\Circular;
use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Id\Service\Parse as ParseId;

/**
 * Parses a deprecation
 *
 * @since  0.1.0
 */
class Parse
{
    /* !Private properties */

    /**
     * @var    ParseId  the parse-identifier service
     * @since  0.1.0
     */
    private $parseId;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  ParseId  $parseId
     * @since  0.1.0
     */
    public function __construct(ParseId $parseId)
    {
        $this->parseId = $parseId;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   string       $id   the deprecated identifier
     * @param   string|null  $replacement  the replacement identifier (optional)
     */
    public function __invoke(string $id, string $replacement = null): Deprecation
    {
        $id = $this->parseId($id);

        if ($replacement) {
            $replacement = $this->parseId($replacement);
            if ($id == $replacement) {
    			throw new Circular($id, $replacement);
    		}
        }

        if ($id instanceof ServiceId) {
            $deprecation = new ServiceDeprecation($id, $replacement);
        } else {
            $deprecation = new SettingDeprecation($id, $replacement);
        }

        return $deprecation;
    }


    /* !Private methods */

    /**
     * Parses an identifier
     *
     * @param   string  $id  the identifier to parse
     * @return  Id
     * @since   0.1.0
     */
    private function parseId(string $id): Id
    {
        return ($this->parseId)($id);
    }
}
