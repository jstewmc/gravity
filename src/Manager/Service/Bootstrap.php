<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Manager\Service;

use Jstewmc\Gravity\{Id, Service, Setting};
use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Project\Data\Project;
use Psr\Log\LoggerInterface as Logger;
use Psr\SimpleCache\CacheInterface as Cache;

/**
 * Bootstraps the manager from the warmed cache and project.
 */
class Bootstrap
{
    public function __invoke(Project $project, Cache $cache, Logger $logger): Manager
    {
        $getId      = $this->getGetId($cache);
        $getService = $this->getGetService($cache, $logger);
        $getSetting = $this->getGetSetting($cache, $logger);

        return new Manager($project, $getId, $getService, $getSetting);
    }

    private function getGetId(Cache $cache): Id\Service\Get
    {
        return new Id\Service\Get(
            $cache->get(strtolower(Id\Service\Render::class)),
            $cache->get(strtolower(Id\Service\Follow::class))
        );
    }

    private function getGetService(Cache $cache, Logger $logger): Service\Service\Get
    {
        return new Service\Service\Get(
            $cache->get(strtolower(Service\Service\Instantiate::class)),
            $cache,
            $logger
        );
    }

    private function getGetSetting(Cache $cache, Logger $logger): Setting\Service\Get
    {
        return new Setting\Service\Get($cache, $logger);
    }
}
