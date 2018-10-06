<?php
/**
 * The file for the read-filesystem service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use DirectoryIterator;
use Jstewmc\Gravity\Filesystem\Data\Filesystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Reads the filesystem
 *
 * I'll read the project's filesystem to find the Gravity files. Keep in mind,
 * Gravity files may be defined at the project or package level.
 *
 * @since  0.1.0
 */
class Read
{
    /* !Magic methods */

    /**
     * Called when the service is treated like a function
     *
     * @param   string  $root  the project's root directory pathname
     * @return  Filesystem
     * @since   0.1.0
     */
    public function __invoke(string $root): Filesystem
    {
        $projectFiles = $this->getProjectFiles($root);

        $packageFiles = $this->getPackageFiles($root);

        $files = array_merge($projectFiles, $packageFiles);

        $filesystem = new Filesystem($files);

        return $filesystem;
    }


    /* !Private methods */

    /**
     * Returns the files in a Gravity directory recursively
     *
     * @param   string  $pathname  the directory's pathname
     * @return  SplFileInfo[]
     * @since   0.1.0
     */
    private function getFiles(string $pathname): array
    {
        $rdi = new RecursiveDirectoryIterator(
            $pathname,
            RecursiveDirectoryIterator::SKIP_DOTS
        );

        $rii = new RecursiveIteratorIterator(
            $rdi,
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        return array_values(iterator_to_array($rii));
    }

    /**
     * Indexes the package Gravity files, if they exist
     *
     * @param   string  $root  the package's root directory pathname
     * @return  SplFileInfo[]
     */
    private function getPackageFiles(string $root): array
    {
        $files = [];

        $pathnames = $this->getPackageGravityDirectoryPathnames($root);

        foreach ($pathnames as $pathname) {
            $files = array_merge($files, $this->getFiles($pathname));
        }

        return $files;
    }

    /**
     * Returns the (actual) pathnames of the package Gravity directories
     *
     * @param   string  $root  the project's root directory pathname
     * @return  string[]
     * @since   0.1.0
     */
    private function getPackageGravityDirectoryPathnames(string $root): array
    {
        $pathnames = [];

        // get the vendors directory pathname
        $vendors = $this->implode($root, Filesystem::DIRECTORY_NAME_VENDORS);

        // if a vendors directory doesn't exist, short-circuit
        if (!$this->isDirectory($vendors)) {
            return [];
        }

        // otherwise, loop through the vendors directory's vendor directories
        foreach (new DirectoryIterator($vendors) as $vendor) {
            // if the item is a vendor directory
            if ($vendor->isDir() && ! $vendor->isDot()) {
                // loop through the vendor directory's package directories
                foreach (new DirectoryIterator($vendor->getPathname()) as $package) {
                    // if the item is a package directory
                    if ($package->isDir() && ! $package->isDot()) {
                        // get the package's (expected) gravity directory pathname
                        $gravity = $this->implode(
                            $package->getPathname(),
                            Filesystem::DIRECTORY_NAME_GRAVITY
                        );
                        // if the directory exists, append it
                        if ($this->isDirectory($gravity)) {
                            $pathnames[] = $gravity;
                        }
                    }
                }
            }
        }

        return $pathnames;
    }

    /**
     * Indexes the project's Gravity files, if they exist
     *
     * @param   string  $root  the project's root directory pathname
     * @return  SplFilInfo[]
     * @since   0.1.0
     */
    private function getProjectFiles(string $root): array
    {
        $files = [];

        $pathname = $this->getProjectGravityDirectoryPathname($root);

        if ($this->isDirectory($pathname)) {
            $files = $this->getFiles($pathname);
        }

        return $files;
    }

    /**
     * Returns the (expected) pathname of the project's Gravity directory
     *
     * @param   string  $root  the project's root directory pathname
     * @return  string
     * @since   0.1.0
     */
    private function getProjectGravityDirectoryPathname(string $root): string
    {
        return $this->implode($root, Filesystem::DIRECTORY_NAME_GRAVITY);
    }

    /**
     * Implodes path (or pattern) segments into a pathname
     *
     * @param   string  $segments  the segments to implode
     * @return  string
     * @since   0.1.0
     */
    private function implode(string ...$segments): string
    {
        return implode(DIRECTORY_SEPARATOR, $segments);
    }

    /**
     * Returns true if $pathname exists, is readable, and is a directory
     *
     * @param   string  $pathname  the pathname to test
     * @return  bool
     */
    private function isDirectory(string $pathname): bool
    {
        return is_readable($pathname) && is_dir($pathname);
    }
}
