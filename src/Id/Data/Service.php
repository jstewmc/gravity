<?php
/**
 * The file for a service identifier
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

/**
 * A service identifier
 *
 * A service identifier is separated by the backslash ("\") character.
 *
 * @since  0.1.0
 */
class Service extends Id
{
    /* !Public constants */

    /**
     * @var    string  the service identifier separator
     * @since  0.1.0
     */
    public const SEPARATOR = '\\';
}
