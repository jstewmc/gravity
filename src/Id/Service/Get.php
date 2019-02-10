<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Project\Data\Project;

class Get
{
    private $follow;

    private $render;

    public function __construct(Render $render, Follow $follow)
    {
        $this->render = $render;
        $this->follow = $follow;
    }

    public function __invoke(string $path, Ns $namespace, Project $project)
    {
        $id = ($this->render)($path, $namespace);
        $id = ($this->follow)($id, $project);

        return $id;
    }
}
