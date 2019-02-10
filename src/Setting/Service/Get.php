<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Cache\Data\Cache;
use Jstewmc\Gravity\Id\Data\Setting as Id;
use Jstewmc\Gravity\Project\Data\Project;

class Get
{
    private $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function __invoke(Id $id, Project $project)
    {
        if ($this->cache->has($id)) {
            return $this->cache->get($id);
        }

        $value = $project->getSetting($id);

        $this->cache->set($id, $value);

        return $value;
    }
}
