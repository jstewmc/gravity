<?php
/**
 * The file for the parse-identifier service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Id\Service;

use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Id\Data\Service;
use Jstewmc\Gravity\Id\Data\Setting;
use Jstewmc\Gravity\Id\Exception\BadLength;
use Jstewmc\Gravity\Path\Data\Path;
use Jstewmc\Gravity\Path\Data\Service as ServicePath;
use Jstewmc\Gravity\Path\Service\Parse as ParsePath;

/**
 * Parses an identifier, a path with three or more segments
 *
 * @since  0.1.0
 */
class Parse
{
    /* !Private properties */

    /**
     * @var    ParsePath  the parse-path service
     * @since  0.1.0
     */
    private $parsePath;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  ParsePath  $parsePath
     * @since  0.1.0
     */
    public function __construct(ParsePath $parsePath)
    {
        $this->parsePath = $parsePath;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   string  $id  the id to parse
     * @return  Id
     * @since   0.1.0
     */
    public function __invoke(string $id): Id
    {
        $path = $this->parsePath($id);

        if ($path->getLength() < 3) {
            throw new BadLength($path);
        }

        if ($path instanceof ServicePath) {
            $id = new Service($path);
        } else {
            $id = new Setting($path);
        }

        return $id;
    }


    /* !Private method */

    /**
     * Parses a path
     *
     * @param   string  $path  the path to parse
     * @return  Path
     * @since   0.1.0
     */
    private function parsePath(string $path): Path
    {
        return ($this->parsePath)($path);
    }
}
