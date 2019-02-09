<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Service\Service;

use Jstewmc\Gravity\Cache\Data\Cache;
use Jstewmc\Gravity\Id\Data\Service as Id;
use Jstewmc\Gravity\Manager;
use Jstewmc\Gravity\Project\Data\Project;

class Get
{
    private $cache;

    private $instantiate;

    public function __construct(Instantiate $instantiate, Cache $cache)
    {
        $this->instantiate = $instantiate;
        $this->cache       = $cache;
    }

    public function __invoke(Id $id, Project $project, Manager $g): object
    {
        if ($this->cache->has($id)) {
            return $this->cache->get($id);
        }

        $service = $project->getService($id);

        $instance = ($this->instantiate)($service, $g);

        $this->cache->set($id, $instance);

        return $instance;
    }
}
