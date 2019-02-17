<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Project\Data\Project;
use Psr\Log\LoggerInterface as Logger;
use Psr\SimpleCache\CacheInterface;

class Get
{
    private $cache;

    public function __construct(CacheInterface $cache, Logger $logger)
    {
        $this->cache  = $cache;
        $this->logger = $logger;
    }

    public function __invoke(Id $id, Project $project)
    {
        if ($this->cache->has($id)) {
            $this->logger->debug("Returned '$id' from cache.");

            return $this->cache->get($id);
        }

        $value = $project->getSetting($id);

        $this->cache->set($id, $value);

        $this->logger->debug("Cached and returned '$id' from project.");

        return $value;
    }
}
