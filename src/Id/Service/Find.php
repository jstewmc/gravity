<?php
/**
 * The file for the find-identifier service
 *
 * @author     Jack Claton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Project\Data\Project;

/**
 * Finds an identifier in the project
 *
 * I'll parse and resolve an identifier (i.e., follow aliases, warn about
 * deprecations, etc.).
 *
 * @since  0.1.0
 */
class Find
{
    /* !Private properties */

    /**
     * @var   Parse  the parse-identifier service
     * @since  0.1.0
     */
    private $parse;

    /**
     * @var    Resolve  the resolve-identifier service
     * @since  0.1.0
     */
    private $resolve;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  Parse    $parse    the parse-identifier service
     * @param  Resolve  $resolve  the resolve-identifier service
     * @since  0.1.0
     */
    public function __construct(Parse $parse, Resolve $resolve)
    {
        $this->parse   = $parse;
        $this->resolve = $resolve;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   string   $id  the identifier to find
     * @param   Project  $project     the project
     * @return  Id
     * @since   0.1.0
     */
    public function __invoke(string $id, Project $project): Id
    {
        $id = $this->parse($id);

        $id = $this->resolve($id, $project);

        return $id;
    }


    /* !Private methods */

    /**
     * Parses an identifier
     *
     * @param   string  $id  the identifier to parse
     * @return  Id
     * @since   0.1.0
     */
    private function parse(string $id): Id
    {
        return ($this->parse)($id);
    }

    /**
     * Resolves an identifier
     *
     * @param   Id  $id  the identifier to resolve
     * @param   Project     $project     the Gravity project
     * @return  Id
     * @since   0.1.0
     */
    private function resolve(Id $id, Project $project): Id
    {
        return ($this->resolve)($id, $project);
    }
}
