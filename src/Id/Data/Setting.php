<?php
/**
 * The file for a setting identifier
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Data;

/**
 * A setting identifier
 *
 * A setting identifier is separated by the period (".") character.
 *
 * @since  0.1.0
 */
class Setting extends Id
{
    /* !Public constants */

    /**
     * @var    string  the setting identifier separator
     * @since  0.1.0
     */
    public const SEPARATOR = '.';
}
