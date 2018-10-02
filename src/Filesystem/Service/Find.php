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
 * Finds the project's filesystem
 *
 * If the project includes a vendors directory (i.e., Gravity was installed by
 * Composer), I will use the project's root directory. Otherwise, I will
 * default to the package's root directory.
 *
 *     <root>                                # the project's root directory
 *     |-- vendor                            # the vendors directory
 *     |   |-- jstewmc
 *     |   |   |-- gravity                   # the package's root directory
 *     |   |   |   |-- src
 *     |   |   |   |   |-- Filesystem
 *     |   |   |   |   |   |-- Service
 *     |   |   |   |   |   |   |-- __FILE__  # this file
 *     7   6   5   4   3   2   1
 *
 * @since  0.1.0
 */
class Find
{
    /* !Private constants */

    /**
     * @var    int  the number of levels to the package's root directory
     * @since  0.1.0
     */
    private const PACKAGE_DIRECTORY_LEVELS = self::PROJECT_DIRECTORY_LEVELS - 3;

    /**
     * @var    int  the number of levels to the project's root directory
     * @since  0.1.0
     */
    private const PROJECT_DIRECTORY_LEVELS = 7;

    /**
     * @var    int  the number of levels to the vendors directory
     * @since  0.1.0
     */
    private const VENDORS_DIRECTORY_LEVELS = self::PROJECT_DIRECTORY_LEVELS - 1;

    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @return  string|null
     * @throws  NotFound      if project's root directory does not exist
     * @throws  NotReadable   if project's root directory is not readable
     * @throws  NotDirectory  if project's root directory is not a directory
     * @return  string
     * @since   0.1.0
     */
    public function __invoke(): string
    {
        if ($this->hasVendorsDirectory()) {
            $pathname = $this->getProjectDirectoryPathname();
        } else {
            $pathname = $this->getPackageDirectoryPathname();
        }

        return $pathname;
    }


    /* !Private methods */

    /**
     * Returns the package's root directory
     *
     * @return  string
     * @since   0.1.0
     */
    private function getPackageDirectoryPathname(): string
    {
        return $this->getPathname(self::PACKAGE_DIRECTORY_LEVELS);
    }

    /**
     * Returns the project's root directory
     *
     * @return  string
     * @since  0.1.0
     */
    private function getProjectDirectoryPathname(): string
    {
        return $this->getPathname(self::PROJECT_DIRECTORY_LEVELS);
    }

    /**
     * Returns true if a vendors directory exists
     *
     * @return  bool
     * @since   0.1.0
     */
    private function hasVendorsDirectory(): bool
    {
        $pathname = $this->getPathname(self::VENDORS_DIRECTORY_LEVELS);

        // if a directory doesn't eixst, short-circuit
        if ( ! $pathname) {
            return false;
        }

        // otherwise, instantiate the directory
        $directory = new SplFileInfo($pathname);

        // if the directory isn't readable or directory (somehow), short-circuit
        if ( ! $directory->isReadable() || ! $directory->isDir()) {
            return false;
        }

        // if the directory's name is incorrect, short-circuit
        if ($directory->getFilename() !== Filesystem::DIRECTORY_NAME_VENDORS) {
            return false;
        }

        return true;
    }

    /**
     * Returns the pathname of a directory $levels above this file
     *
     * @param   int  $levels  the levels above this file
     * @return  string|null
     * @since   0.1.0
     */
    private function getPathname(int $levels): ?string
    {
        if (false === ($pathname = realpath(dirname(__FILE__, $levels)))) {
            return null;
        }

        return $pathname;
    }
}
