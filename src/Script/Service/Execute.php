<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Script\Data\Interpreted;
use Jstewmc\Gravity\Project\Data\Project;

class Execute
{
    public function __invoke(Interpreted $script, Project $project): Project
    {
        foreach ($script->getAliases() as $alias) {
            $project->addAlias($alias);
        }

        foreach ($script->getDeprecations() as $deprecation) {
            $project->addDeprecation($deprecation);
        }

        foreach ($script->getServices() as $service) {
            $project->addService($service);
        }

        foreach ($script->getSettings() as $setting) {
            $project->addSetting($setting);
        }

        return $project;
    }
}
