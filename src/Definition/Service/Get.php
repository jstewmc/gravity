<?php
/**
 * The file for the get-definition service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Service;

use Jstewmc\Gravity\Cache\Data\Cache;
use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Id\Service\Find as FindId;
use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Service\Service\Get as GetService;
use Jstewmc\Gravity\Setting\Service\Get as GetSetting;


/**
 * The get-definition service
 *
 * @since  0.1.0
 */
class Get
{
    /* !Private properties */

    /**
     * @var    Cache  the cache to use
     * @since  0.1.0
     */
    private $cache;

    /**
     * @var    FindId  the find-id service
     * @since  0.1.0
     */
    private $findId;

    /**
     * @var    GetService  the get-service service
     * @since  0.1.0
     */
    private $getService;

    /**
     * @var    GetSetting  the get-setting service
     * @since  0.1.0
     */
    private $getSetting;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param   FindId      $findId      the find-identifier service
     * @param   GetService  $getService  the get-service service
     * @param   GetSetting  $getSetting  the get-setting service
     * @param   Cache       $cache       the cache to use
     */
    public function __construct(
        FindId      $findId,
        GetService  $getService,
        GetSetting  $getSetting,
        Cache       $cache
    ){
        $this->findId      = $findId;
        $this->getService  = $getService;
        $this->getSetting  = $getSetting;
        $this->cache       = $cache;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   string   $id       the identifier to get
     * @param   Project  $project  the project
     * @return  mixed
     * @since   0.1.0
     */
    public function __invoke(string $id, Project $project)
    {
        $id = $this->findId($id, $project);

        if ($this->cache->has($id)) {
            return $this->cache->get($id);
        }

        if ($id instanceof SettingId) {
            $value = $this->getSetting($id, $project);
        } else {
            $value = $this->getService($id, $project);
        }

        $this->cache->set($id, $value);

        return $value;
    }


    /* !Private methods */

    /**
     * Finds an identifier in the project
     *
     * @param   string   $id       the identifier to find
     * @param   Project  $project  the project
     * @return  object
     * @since   0.1.0
     */
    private function findId(string $id, Project $project): Id
    {
        return ($this->findId)($id, $project);
    }

    /**
     * Returns a service
     *
     * @param   ServiceId  $id       the service's identifier
     * @param   Project    $project  the project
     * @return  object
     * @since   0.1.0
     */
    private function getService(ServiceId $id, Project $project): object
    {
        return ($this->getService)($id, $project);
    }

    /**
     * Returns a setting
     *
     * @param   SettingId  $id       the setting's identifier
     * @param   Project    $project  the project
     * @return  mixed
     * @since   0.1.0
     */
    private function getSetting(SettingId $id, Project $project)
    {
        return ($this->getSetting)($id, $project);
    }
}
