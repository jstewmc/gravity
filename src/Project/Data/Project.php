<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Project\Data;

use Jstewmc\Gravity\Alias\Data\Resolved as Alias;
use Jstewmc\Gravity\Alias\Exception\NotFound as AliasNotFound;
use Jstewmc\Gravity\Deprecation\Data\Resolved as Deprecation;
use Jstewmc\Gravity\Deprecation\Exception\NotFound as DeprecationNotFound;
use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Root\Data\Root;
use Jstewmc\Gravity\Service\Data\Service;
use Jstewmc\Gravity\Service\Exception\NotFound as ServiceNotFound;
use Jstewmc\Gravity\Setting\Data\Setting;
use Jstewmc\Gravity\Setting\Exception\NotFound as SettingNotFound;

class Project
{
    private $aliases = [];

    private $deprecations = [];

    private $root;

    private $services = [];

    private $settings = [];

    public function __construct(Root $root)
    {
        $this->root = $root;
    }

    public function addAlias(Alias $alias): self
    {
        $this->aliases[(string)$alias->getSource()] = $alias;

        return $this;
    }

    public function addDeprecation(Deprecation $deprecation): self
    {
        $this->deprecations[(string)$deprecation->getSource()] = $deprecation;

        return $this;
    }

    public function addService(Service $service): self
    {
        $this->services[(string)$service->getId()] = $service;

        return $this;
    }

    public function addSetting(Setting $setting): self
    {
        $this->settings = uarray_merge_recursive(
            $this->settings,
            $setting->getArray()
        );

        return $this;
    }

    public function getAlias(Id $id): Alias
    {
        if (!$this->hasAlias($id)) {
            throw new AliasNotFound($id);
        }

        return $this->aliases[(string)$id];
    }

    public function getDeprecation(Id $id): Deprecation
    {
        if (!$this->hasDeprecation($id)) {
            throw new DeprecationNotFound($id);
        }

        return $this->deprecations[(string)$id];
    }

    public function getRoot(): Root
    {
        return $this->root;
    }

    public function getService(ServiceId $id): Service
    {
        if (!$this->hasService($id)) {
            throw new ServiceNotFound($id);
        }

        return $this->services[(string)$id];
    }

    public function getSetting(SettingId $id)
    {
        if (!$this->hasSetting($id)) {
            throw new SettingNotFound($id);
        }

        $settings = $this->settings;

        foreach ($id->getSegments() as $segment) {
            $settings = $settings[$segment];
        }

        return $settings;
    }

    public function hasAlias(Id $id): bool
    {
        return array_key_exists((string)$id, $this->aliases);
    }

    public function hasDeprecation(Id $id): bool
    {
        return array_key_exists((string)$id, $this->deprecations);
    }

    public function hasService(Id $id): bool
    {
        return array_key_exists((string)$id, $this->services);
    }

    public function hasSetting(Id $id): bool
    {
        $settings = $this->settings;

        foreach ($id->getSegments() as $segment) {
            if (!array_key_exists($segment, $settings)) {
                return false;
            }
            $settings = $settings[$segment];
        }

        return true;
    }
}
