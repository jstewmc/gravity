<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Cache\Service;

use Jstewmc\Gravity\Cache\Data\Cache;
use Jstewmc\Gravity\{Deprecation, Id, Path, Service};
use Psr\Log\LoggerInterface;

/**
 * Defines the minimum services required for bootstraping. Excludes services
 * which depend on the cache to prevent circular references.
 */
class Warm
{
    public function __invoke(Cache $cache, LoggerInterface $logger)
    {
        $cache = $this->setServiceServices($cache);
        $cache = $this->setDeprecationServices($cache);
        $cache = $this->setPathServices($cache, $logger);

        // requires path and deprecation
        $cache = $this->setIdServices($cache);

        return $cache;
    }

    private function setPathServices(Cache $cache, LoggerInterface $logger): Cache
    {
        $parse   = new Path\Service\Parse();
        $merge   = new Path\Service\Merge();
        $resolve = new Path\Service\Resolve($merge, $logger);

        $cache->set(strtolower(Path\Service\Parse::class), $parse);
        $cache->set(strtolower(Path\Service\Merge::class), $merge);
        $cache->set(strtolower(Path\Service\Resolve::class), $resolve);

        return $cache;
    }

    private function setDeprecationServices(Cache $cache): Cache
    {
        $cache->set(
            strtolower(Deprecation\Service\Warn::class),
            new Deprecation\Service\Warn()
        );

        return $cache;
    }

    private function setIdServices(Cache $cache): Cache
    {
        $render = new Id\Service\Render(
            $cache->get(strtolower(Path\Service\Parse::class)),
            $cache->get(strtolower(Path\Service\Resolve::class))
        );

        $follow = new Id\Service\Follow(
            $cache->get(strtolower(Deprecation\Service\Warn::class))
        );

        $cache->set(strtolower(Id\Service\Render::class), $render);
        $cache->set(strtolower(Id\Service\Follow::class), $follow);

        return $cache;
    }

    private function setServiceServices(Cache $cache): Cache
    {
        $cache->set(
            strtolower(Service\Service\Instantiate::class),
            new Service\Service\Instantiate()
        );

        return $cache;
    }
}
