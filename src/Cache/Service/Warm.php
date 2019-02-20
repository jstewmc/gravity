<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Service;

use Jstewmc\Gravity\{Deprecation, Id, Path, Service};
use Psr\Log\LoggerInterface as Logger;
use Psr\SimpleCache\CacheInterface as Cache;
use function strtolower;

/**
 * Defines the minimum services required for bootstraping. Excludes services
 * which depend on the cache to prevent circular references.
 */
class Warm
{
    public function __invoke(Cache $cache, Logger $logger)
    {
        $this->setServiceServices($cache, $logger)
             ->setDeprecationServices($cache, $logger)
             ->setPathServices($cache, $logger)
             ->setIdServices($cache, $logger);

        return $cache;
    }

    private function setPathServices(Cache $cache, Logger $logger): self
    {
        $parse   = new Path\Service\Parse();
        $merge   = new Path\Service\Merge();
        $resolve = new Path\Service\Resolve($merge, $logger);

        $cache->set(strtolower(Path\Service\Parse::class), $parse);
        $cache->set(strtolower(Path\Service\Merge::class), $merge);
        $cache->set(strtolower(Path\Service\Resolve::class), $resolve);

        return $this;
    }

    private function setDeprecationServices(Cache $cache, Logger $logger): self
    {
        $warn = new Deprecation\Service\Warn($logger);

        $cache->set(strtolower(Deprecation\Service\Warn::class), $warn);

        return $this;
    }

    private function setIdServices(Cache $cache, Logger $logger): self
    {
        $render = new Id\Service\Render(
            $cache->get(strtolower(Path\Service\Parse::class)),
            $cache->get(strtolower(Path\Service\Resolve::class))
        );

        $follow = new Id\Service\Follow(
            $cache->get(strtolower(Deprecation\Service\Warn::class)),
            $logger
        );

        $cache->set(strtolower(Id\Service\Render::class), $render);
        $cache->set(strtolower(Id\Service\Follow::class), $follow);

        return $this;
    }

    private function setServiceServices(Cache $cache, Logger $logger): self
    {
        $cache->set(
            strtolower(Service\Service\Instantiate::class),
            new Service\Service\Instantiate()
        );

        return $this;
    }
}
