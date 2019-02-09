<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Path\Service\{Parse, Resolve};

class Render
{
    private $parse;

    private $resolve;

    public function __construct(Parse $parse, Resolve $resolve)
    {
        $this->parse   = $parse;
        $this->resolve = $resolve;
    }

    public function __invoke(string $path, Ns $namespace): Id
    {
        $path = ($this->parse)($path);
        $id   = ($this->resolve)($path, $namespace);

        return $id;
    }
}
