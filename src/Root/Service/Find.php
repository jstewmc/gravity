<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Root\Service;

use Jstewmc\Gravity\Filesystem\Data\Filesystem;
use Jstewmc\Gravity\Root\Data\Root;
use Jstewmc\Gravity\Root\Exception\{NotDirectory, NotFound, NotReadable};
use SplFileInfo;

/**
 * Finds the project's root directory
 *
 * If this file's parent directories include a vendors directory, I'll assume
 * Gravity was installed by Composer. Gravity is likely being used for real.
 *
 * Otherwise, I'll return the package's root directory. Gravity is likely
 * being tested or developed.
 *
 * I assume the following directory structure:
 *
 *     <root>                                # the project's root directory
 *     |-- vendor                            # the vendors directory
 *     |   |-- jstewmc
 *     |   |   |-- gravity                   # the package's root directory
 *     |   |   |   |-- src
 *     |   |   |   |   |-- Root
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
     * @var  int  the number of levels to the package's root directory
     */
    private const PACKAGE_DIRECTORY_LEVELS = self::PROJECT_DIRECTORY_LEVELS - 3;

    /**
     * @var  int  the number of levels to the project's root directory
     */
    private const PROJECT_DIRECTORY_LEVELS = 7;

    /**
     * @var  int  the number of levels to the vendors directory
     */
    private const VENDORS_DIRECTORY_LEVELS = self::PROJECT_DIRECTORY_LEVELS - 1;

    public function __invoke(): Root
    {
        if ($this->hasVendorsDirectory()) {
            $pathname = $this->getProjectDirectoryPathname();
        } else {
            $pathname = $this->getPackageDirectoryPathname();
        }

        if ($pathname === null) {
            throw new NotFound();
        }

        if (!is_readable($pathname)) {
            throw new NotReadable($pathname);
        }

        if (!is_dir($pathname)) {
            throw new NotDirectory($pathname);
        }

        $root = new Root($pathname);

        return $root;
    }

    private function getPackageDirectoryPathname(): string
    {
        return $this->getPathname(self::PACKAGE_DIRECTORY_LEVELS);
    }

    private function getProjectDirectoryPathname(): string
    {
        return $this->getPathname(self::PROJECT_DIRECTORY_LEVELS);
    }

    private function hasVendorsDirectory(): bool
    {
        $pathname = $this->getPathname(self::VENDORS_DIRECTORY_LEVELS);

        if ($pathname === null) {
            return false;
        }

        $directory = new SplFileInfo($pathname);

        if (!$directory->isReadable() || ! $directory->isDir()) {
            return false;
        }

        if ($directory->getFilename() !== Filesystem::DIRECTORY_NAME_VENDORS) {
            return false;
        }

        return true;
    }

    /**
     * Returns the pathname of a directory $levels above this file, or null if
     * it doesn't exist
     */
    private function getPathname(int $levels): ?string
    {
        if (false === ($pathname = realpath(dirname(__FILE__, $levels)))) {
            return null;
        }

        return $pathname;
    }
}
