<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\Deprecation;

class Warn
{
    public function __invoke(Deprecation $deprecation): void
    {
        trigger_error($this->getMessage($deprecation), E_USER_DEPRECATED);
    }

    private function getMessage(Deprecation $deprecation): string
    {
        $message = "The service, setting, or alias "
            . "'{$deprecation->getSource()}' has been deprecated and "
            . "should be ";

        if ($deprecation->hasReplacement()) {
            $message .= "replaced with '{$deprecation->getReplacement()}'";
        } else {
            $message .= "removed";
        }

        return $message;
    }
}
