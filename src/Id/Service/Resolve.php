<?php
/**
 * The file for the resolve-identifier service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Deprecation\Data\Deprecation;
use Jstewmc\Gravity\Deprecation\Service\Warn as WarnDeprecation;
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Project\Data\Project;

/**
 * Recursively resolves an identifier to a final destination
 *
 * @since  0.1.0
 */
class Resolve
{
    /* !Magic methods */

    /**
     * @var    WarnDeprecation  the warn-deprecation service
     * @since  0.1.0
     */
    private $warnDeprecation;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param   WarnDeprecation  $warnDeprecation
     * @since  0.1.0
     */
    public function __construct(WarnDeprecation $warnDeprecation)
    {
        $this->warnDeprecation = $warnDeprecation;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   Id  $id  the
     * @return  Id
     * @since   0.1.0
     */
    public function __invoke(Id $id, Project $project): Id
    {
        // if the identifier is deprecated, trigger a warning
        if ($project->hasDeprecation($id)) {
            $this->warnDeprecation($project->getDeprecation($id));
        }

        // if the identifier is an alias
        if ($project->hasAlias($id)) {
            // get the alias' destination
            $destination = $project->getAlias($id)->getDestination();
            // resolve the destination
            $id = ($this)($destination, $project);
        }

        return $id;
    }


    /* !Private methods */

    /**
     * Warns a deprecated alias, service, or setting has been used
     *
     * @param   Deprecation  $deprecation  the deprecation to warn about
     * @return  void
     * @since   0.1.0
     */
    private function warnDeprecation(Deprecation $deprecation): void
    {
        ($this->warnDeprecation)($deprecation);

        return;
    }
}
