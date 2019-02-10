<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Project\Service;

use Jstewmc\Gravity\Filesystem\Data\Loaded;
use Jstewmc\Gravity\Project\Data\Project;

class Hydrate
{
    public function __invoke(Project $project, Loaded $filesystem): Project
    {
        foreach ($filesystem->getFiles() as $file) {
            foreach ($file->getAliases() as $alias) {
                $project->addAlias($alias);
            }

            foreach ($file->getDeprecations() as $deprecation) {
                $project->addDeprecation($deprecation);
            }

            foreach ($file->getServices() as $service) {
                $project->addService($service);
            }

            foreach ($file->getSettings() as $setting) {
                $project->addSetting($setting);
            }
        }

        return $project;
    }
}
