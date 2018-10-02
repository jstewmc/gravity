<?php
/**
 * The file for the find-filesystem service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use Jstewmc\Gravity\Filesystem\Data\Filesystem;
use Jstewmc\Gravity\Filesystem\Exception\NotDirectory;
use Jstewmc\Gravity\Filesystem\Exception\NotFound;
use Jstewmc\Gravity\Filesystem\Exception\NotReadable;
use SplFileInfo;

/**
 * Finds the project's filesystem if installed by Composer
 *
 * If the library is installed by Composer, I can find the project's root
 * directory, because I know my relative location.
 *
 *     <root>
 *     |-- vendor
 *     |   |-- jstewmc
 *     |   |   |-- gravity
 *     |   |   |   |-- src
 *     |   |   |   |   |-- Filesystem
 *     |   |   |   |   |   |-- Service
 *     |   |   |   |   |   |   |-- __FILE__
 *     6   5   4   3   2   1
 *
 * @since  0.1.0
 */
class Find
{
    /* !Private constants */

    /**
     * @var    int  the number of levels down from the root directory
     * @since  0.1.0
     */
    private const LEVELS = 6;

    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @return  string|null
     * @throws  NotFound      if project's root directory does not exist
     * @throws  NotReadable   if project's root directory is not readable
     * @throws  NotDirectory  if project's root directory is not a directory
     * @since   0.1.0
     */
    public function __invoke(): ?string
    {
        if (!$this->isComposer()) {
            return null;
        }

        $pathname = realpath(dirname(__FILE__, self::LEVELS));

        if ($pathname === false) {
            throw new NotFound($pathname);
        }

        if (!is_readable($pathname)) {
            throw new NotReadable($pathname);
        }

        if (!is_dir($pathname)) {
            throw new NotDirectory($pathname);
        }

        return $pathname;
    }


    /* !Private methods */

    /**
     * Returns true if the package was installed using Composer
     * I assume the package is installed by Composer if the directory
     * immediately below the expected root directory is the Composer directory.
     * This may be false in some situations, but it seems like a sensible
     * assumption.
     *
     * @return  bool
     * @since   0.1.0
     */
    private function isComposer(): bool
    {
        $pathname = realpath(dirname(__FILE__, self::LEVELS - 1));

        if (!$pathname) {
            return false;
        }

        $directory = new SplFileInfo($pathname);

        if (!$directory->isReadable() || !$directory->isDir()) {
            return false;
        }

        $expected = Filesystem::DIRECTORY_NAME_VENDORS;
        $actual   = $directory->getFilename();

        return $expected === $actual;
    }
}
