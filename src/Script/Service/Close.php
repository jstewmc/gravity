<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Script\Data\{Closed, Opened};

class Close
{
    public function __invoke(Opened $script): Closed
    {
        return (new Closed())
            ->setAliases($script->getAliases())
            ->setDefinitions($script->getDefinitions())
            ->setDeprecations($script->getDeprecations());
    }
}
