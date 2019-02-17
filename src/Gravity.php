<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\{Cache\Data\Hash, Cache\Service\Warm, Manager, Project};
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface as Cache;

class Gravity
{
    /** @var Cache */
    private $cache;

    /** @var LoggerInterface  */
    private $logger;

    public function __construct()
    {
        $this->cache  = new Hash();
        $this->logger = new NullLogger();
    }

    public function pull(): Manager\Data\Manager
    {
        $this->warmCache();

        $project = $this->bootstrapProject($this->logger);
        $manager = $this->bootstrapManager($project);

        $this->load($project, $manager);

        return $manager;
    }

    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function setCache(Cache $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    private function bootstrapManager(Project\Data\Project $project): Manager\Data\Manager
    {
        $bootstrap = new Manager\Service\Bootstrap();
        $project   = $bootstrap($project, $this->cache, $this->logger);

        return $project;
    }

    private function bootstrapProject(
        LoggerInterface $logger
    ): Project\Data\Project {
        $root = (new Root\Service\Find('vendor'))();

        $project = new Project\Data\Project($root);
        $project = (new Project\Service\Bootstrap())($project, $logger);

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
        (new Warm())($this->cache, $this->logger);
    }
}
