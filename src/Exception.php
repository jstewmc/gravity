<?php
/**
 * The file for a Gravity exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Exception as PHPException;
use Psr\Container\ContainerExceptionInterface;

/**
 * Thrown when an exception occurs in Gravity
 *
 * @since  0.1.0
 */
abstract class Exception extends PHPException implements ContainerExceptionInterface
{
    // nothing yet
}
