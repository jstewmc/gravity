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

/**
 * Bootstraps the manager from the warmed cache and project.
 */
class Bootstrap
{
    public function __invoke(Project $project, Cache $cache): Manager
    {
        $getId      = $this->getGetId($cache);
        $getService = $this->getGetService($cache);
        $getSetting = $this->getGetSetting($cache);

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

    private function getGetService(Cache $cache)
    {
        return new Service\Service\Get(
            $cache->get(strtolower(Service\Service\Instantiate::class)),
            $cache
        );
    }

    private function getGetSetting(Cache $cache)
    {
        return new Setting\Service\Get($cache);
    }
}
