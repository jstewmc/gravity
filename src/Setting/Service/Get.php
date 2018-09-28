<?php
/**
 * The file for the get-setting service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Service;

use Jstewmc\Gravity\Id\Data\Setting;
use Jstewmc\Gravity\Project\Data\Project;

/**
 * Returns a setting from the project
 *
 * Unlike services, getting settings is very straightforward. It's only a
 * separate service so we can treat it similarly to services.
 *
 * @since  0.1.0
 */
class Get
{
    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @param   Setting  $id       the setting's identifier
     * @param   Project  $project  the project
     * @return  mixed
     * @since   0.1.0
     */
    public function __invoke(Setting $id, Project $project)
    {
        return $project->getSetting($id);
    }
}
