<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\DetectEnvironment\DetectEnvironment;
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

        $project = $this->bootstrapProject();

        $manager = $this->bootstrapManager($project);

        $environment = $this->detectEnvironment();

        $this->load($project, $manager, $environment);

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

        return $bootstrap($project, $this->cache, $this->logger);
    }

    private function bootstrapProject(): Project\Data\Project
    {
        $root = (new Root\Service\Find('vendor'))();

        $project = new Project\Data\Project($root);
        $project = (new Project\Service\Bootstrap())($project, $this->logger);

        return $project;
    }

    private function detectEnvironment(): string
    {
        $values = [
            'development' => 'development',
            'testing'     => 'test',
            'staging'     => 'staging',
            'production'  => 'production'
        ];

        try {
            // rename "testing" to "test"
            $environment = (new DetectEnvironment('GRAVITY_ENV', $values))();
            $environment = $environment === 'testing' ? 'test' : $environment;

            return $environment;
        } catch (\OutOfBoundsException $e) {
            return 'development';
        }

        return $environment;
    }

    private function load(
        Project\Data\Project $project,
        Manager\Data\Manager $g,
        string               $environment
    ): void {
        $traverse = $g->get(Filesystem\Service\Traverse::class);
        $load     = $g->get(Filesystem\Service\Load::class);
        $hydrate  = $g->get(Project\Service\Hydrate::class);

        $filesystem = $traverse($project->getRoot(), $environment);
        $filesystem = $load($filesystem);

        $hydrate($project, $filesystem);
    }

    private function warmCache(): void
    {
        (new Warm())($this->cache, $this->logger);
    }
}
