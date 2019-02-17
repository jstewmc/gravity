<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Project\Data\Project;
use Psr\Log\LoggerInterface as Logger;
use Psr\SimpleCache\CacheInterface as Cache;

class Get
{
    private $cache;

    private $instantiate;

    private $logger;

    public function __construct(
        Instantiate $instantiate,
        Cache       $cache,
        Logger      $logger
    ) {
        $this->instantiate = $instantiate;
        $this->cache       = $cache;
        $this->logger      = $logger;
    }

    public function __invoke(Id $id, Project $project, Manager $g): object
    {
        if ($this->cache->has($id)) {
            $this->logger->debug("Returned '$id' from cache.");

            return $this->cache->get($id);
        }

        $service = $project->getService($id);

        $instance = ($this->instantiate)($service, $g);

        $this->cache->set($id, $instance);

        $this->logger->debug(
            "Instantiated, cached, and returned '$id' from project."
        );

        return $instance;
    }
}
