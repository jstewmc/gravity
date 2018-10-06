<?php
/**
 * The file for the "deprecation not found" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Thrown when a deprecation is not found
 *
 * @since  0.1.0
 */
class NotFound extends Exception implements NotFoundExceptionInterface
{
    // nothing yet
}
