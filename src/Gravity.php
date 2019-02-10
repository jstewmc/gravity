<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\{Cache, Manager, Project};


// (new Gravity())->setCache($cache)->pull();
class Gravity
{
    private $cache;

    public function __construct()
    {
        $this->cache = new Cache\Data\Hash();
    }

    public function pull()
    {
        $this->warmCache();

        $project = $this->bootstrapProject();
        $manager = $this->bootstrapManager($project);

        $this->load($project, $manager);

        return $manager;
    }

    public function setCache(Cache\Data\Cache $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    private function bootstrapManager(Project\Data\Project $project): Manager\Data\Manager
    {
        return (new Manager\Service\Bootstrap())($project, $this->cache);
    }

    private function bootstrapProject(): Project\Data\Project
    {
        $root = (new Root\Service\Find('vendor'))();

        $project = new Project\Data\Project($root);
        $project = (new Project\Service\Bootstrap())($project);

        return $project;
    }

    private function load(Project\Data\Project $project, Manager\Data\Manager $g): void
    {
        $traverse = $g->get(Filesystem\Service\Traverse::class);
        $load     = $g->get(Filesystem\Service\Load::class);
        $hydrate  = $g->get(Project\Service\Hydrate::class);

        $filesystem = $traverse($project->getRoot());
        $filesystem = $load($filesystem);

        $hydrate($project, $filesystem);
    }

    private function warmCache(): void
    {
        (new Cache\Service\Warm())($this->cache);
    }
}
