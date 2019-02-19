<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Project\Service;

use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Service\Data\Service;
use Jstewmc\Gravity\Service\Service\Instantiate;

class Validate
{
    private $instantiate;

    public function __construct(Instantiate $instantiate)
    {
        $this->instantiate = $instantiate;
    }

    public function __invoke(Project $project, Manager $g): array
    {
        return array_merge(
            $this->validateRequirements($project),
            $this->validateServices($project, $g)
        );
    }

    private function instantiate(Service $service, Manager $g): object
    {
        return ($this->instantiate)($service, $g);
    }

    private function validateRequirements(Project $project): array
    {
        $errors = [];

        foreach ($project->getRequirements() as $requirement) {
            if ($requirement->isService()) {
                if (!$project->hasService($requirement->getKey())) {
                    $errors[(string)$requirement->getKey()] = "Required "
                        . "service, '{$requirement->getKey()}', not found";
                }
            } else {
                if (!$project->hasSetting($requirement->getKey())) {
                    $errors[(string)$requirement->getKey()] = "Required "
                        . "setting, '{$requirement->getKey()}', not found";
                }
            }
        }

        return $errors;
    }

    private function validateServices(Project $project, Manager $g): array
    {
        $errors = [];

        foreach ($project->getServices() as $service) {
            try {
                $this->instantiate($service, $g);
            } catch (\Throwable $e) {
                $errors[(string)$service->getId()] = "Instatiating service, "
                    . "'{$service->getId()}', failed with " . get_class($e)
                    . ": " . $e->getMessage();
            }
        }

        return $errors;
    }
}
