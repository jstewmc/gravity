<?php
/**
 * The file for a "service not found" exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Exception;

use Jstewmc\Gravity\Id\Data\Service as Id;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Thrown when a service can't be found
 *
 * @since  0.1.0
 */
class NotFound extends Exception implements NotFoundExceptionInterface
{
    /* !Magic methods */

    /**
     * Called when the exception is constructed
     *
     * @param  Id  $id  the service identifier
     * @param  mixed       $value       the invalid definition
     * @since  0.1.0
     */
    public function __construct(Id $id)
    {
        parent::__construct($id);

        $this->message = "Service '$id' not found";
    }
}
