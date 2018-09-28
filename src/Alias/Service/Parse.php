<?php
/**
 * The file for the parse-alias service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Service;

use Jstewmc\Gravity\Alias\Data\{
    Alias,
    Service as ServiceAlias,
    Setting as SettingAlias
};
use Jstewmc\Gravity\Alias\Exception\Circular;
use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Id\Service\Parse as ParseId;


/**
 * Parses a setting or service alias
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
     * Called when the alias is constructed
     *
     * @param  ParseId
     * @since  0.1.0
     */
    public function __construct(ParseId $parseId)
    {
        $this->parseId = $parseId;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   string  $source       the source identifier
     * @param   string  $destination  the destination identifier
     * @return  Alias
     * @throws  Circular  if $source equals $destination
     * @since   0.1.0
     */
    public function __invoke(string $source, string $destination): Alias
    {
        $source      = $this->parseId($source);
        $destination = $this->parseId($destination);

        if ($source == $destination) {
			throw new Circular($source, $destination);
		}

		if ($source instanceof ServiceId) {
			$alias = new ServiceAlias($source, $destination);
		} else {
			$alias = new SettingAlias($source, $destination);
		}

        return $alias;
    }


    /* !Private methods */

    /**
     * Parses a string identifier
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
