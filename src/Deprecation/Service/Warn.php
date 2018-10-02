<?php
/**
 * The file for the warn-deprecation service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\Deprecation;

/**
 * Triggers an E_USER_DEPRECATED error
 *
 * @since  0.1.0
 */
class Warn
{
    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @param   Deprecation $deprecation the deprecation used
     * @return  void
     * @since   0.1.0
     */
    public function __invoke(Deprecation $deprecation): void
    {
        $message = $this->getMessage($deprecation);

        trigger_error($message, E_USER_DEPRECATED);

        return;
    }


    /* !Private methods */

    /**
     * Creates the error message
     *
     * @param   Deprecation $deprecation
     * @return  string
     * @since   0.1.0
     */
    private function getMessage(Deprecation $deprecation): string
    {
        $message = "The service, setting, or alias "
            . "'{$deprecation->getId()}' has been deprecated and "
            . "should be ";

        if ($deprecation->hasReplacement()) {
            $message .= "replaced with '{$deprecation->getReplacement()}'";
        } else {
            $message .= "removed";
        }

        return $message;
    }
}
