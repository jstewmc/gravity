<?php
/**
 * The file for the load-filesystem service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use Jstewmc\Gravity\Filesystem\Data\Filesystem;
use Jstewmc\Gravity\Manager;

/**
 * Loads the filesystem into the Gravity manager
 *
 * @since  0.1.0
 */
class Load
{
    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @param   Filesystem $filesystem the filesystem to read
     * @param   Manager    $g          the Gravity manager
     * @return  Manager
     * @since   0.1.0
     */
    public function __invoke(Filesystem $filesystem, Manager $g): Manager
    {
        foreach ($filesystem->getFiles() as $file) {
            include $file->getPathname();
        }

        return $g;
    }
}
