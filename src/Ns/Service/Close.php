<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Ns\Service;

use Jstewmc\Gravity\Ns\Data\{Closed, Opened};

class Close
{
    public function __invoke(Opened $old): Closed
    {
        $new = new Closed();

        if ($old->hasName()) {
            $new->setName($old->getName());
        }

        if ($old->hasImports()) {
            $new->setImports($old->getImports());
        }

        return $new;
    }
}
