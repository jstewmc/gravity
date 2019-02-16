<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Manager\Service;

use Jstewmc\Gravity\{Id, Service, Setting};
use Jstewmc\Gravity\Cache\Data\Cache;
use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Project\Data\Project;
use Psr\Log\LoggerInterface as Logger;

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

        $manager = new Manager($project, $getId, $getService, $getSetting);

        return $manager;
    }

    private function getGetId(Cache $cache)
    {
        return new Id\Service\Get(
            $cache->get(strtolower(Id\Service\Render::class)),
            $cache->get(strtolower(Id\Service\Follow::class))
        );
    }

    private function getGetService(Cache $cache, Logger $logger)
    {
        return new Service\Service\Get(
            $cache->get(strtolower(Service\Service\Instantiate::class)),
            $cache,
            $logger
        );
    }

    private function getGetSetting(Cache $cache, Logger $logger)
    {
        return new Setting\Service\Get($cache, $logger);
    }
}
