<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Service;

use Jstewmc\Gravity\Deprecation\Data\Deprecation;
use Psr\Log\LoggerInterface;

class Warn
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Deprecation $deprecation): void
    {
        $message = $this->getMessage($deprecation);

        $this->logger->warning($message);

        trigger_error($message, E_USER_DEPRECATED);
    }

    private function getMessage(Deprecation $deprecation): string
    {
        $message = "'{$deprecation->getSource()}' has been deprecated and "
            . "should be ";

        if ($deprecation->hasReplacement()) {
            $message .= "replaced with '{$deprecation->getReplacement()}'";
        } else {
            $message .= "removed";
        }

        return $message;
    }
}
