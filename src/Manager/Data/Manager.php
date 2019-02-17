<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Manager\Data;

use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Id\Service\Get as GetId;
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Service\Service\Get as GetService;
use Jstewmc\Gravity\Setting\Service\Get as GetSetting;
use SplStack;

class Manager
{
    /** @var GetId */
    private $getId;

    /** @var GetService */
    private $getService;

    /** @var GetSetting */
    private $getSetting;

    /** @var SplStack */
    private $namespaces;

    /** @var Project */
    private $project;

    public function __construct(
        Project    $project,
        GetId      $getId,
        GetService $getService,
        GetSetting $getSetting
    ) {
        $this->project    = $project;

        $this->getId      = $getId;
        $this->getService = $getService;
        $this->getSetting = $getSetting;

        // the default global namespace
        $this->namespaces = new SplStack();
        $this->namespaces->push(new Ns());
    }

    public function enter(Ns $namespace): void
    {
        $this->namespaces->push($namespace);
    }

    public function exit(): void
    {
        $this->namespaces->pop();
    }

    public function get(string $path)
    {
        $id = $this->getId($path);

        if ($id instanceof ServiceId) {
            $value = $this->getService($id);
        } else {
            $value = $this->getSetting($id);
        }

        return $value;
    }

    public function has(string $path): bool
    {
        $id = $this->getId($path);

        if ($id instanceof ServiceId) {
            $has = $this->project->hasService($id);
        } else {
            $has = $this->project->hasSetting($id);
        }

        return $has;
    }

    private function getId(string $path): Id
    {
        return ($this->getId)($path, $this->namespaces->top(), $this->project);
    }

    private function getService(Id $id)
    {
        return ($this->getService)($id, $this->project, $this);
    }

    private function getSetting(Id $id)
    {
        return ($this->getSetting)($id, $this->project);
    }
}
