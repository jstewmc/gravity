<?php
/**
 * @copyright  2018 Jack Clayton
 * @license  MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use DirectoryIterator;
use Jstewmc\Gravity\Filesystem\Data\{Found, Traversed};
use Jstewmc\Gravity\Root\Data\Root;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Traverse
{
    private $directories;

    /**
     * @param  string[]  $directories  an array of directory names with keys
     *   "gravity" and "vendors"
     */
    public function __construct(array $directories)
    {
        $this->directories = $directories;
    }

    public function __invoke(Root $root): Traversed
    {
        $projectFiles = $this->getProjectFiles($root);
        $packageFiles = $this->getPackageFiles($root);

        $files = array_merge($projectFiles, $packageFiles);

        $filesystem = new Traversed($files);

        return $filesystem;
    }


    private function getGravityDirectoryName(): string
    {
        return $this->directories['gravity'];
    }

    /**
     * Recursively lists the files in a directory
     *
     * @return  SplFileInfo[]
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
     * @return  string[]
     */
    private function getPackageGravityDirectoryPathnames(string $root): array
    {
        $pathnames = [];

        $vendors = $this->implode($root, $this->getVendorsDirectoryName());

        if (!$this->isDirectory($vendors)) {
            return [];
        }

        // otherwise, loop through the vendors directory's vendor directories
        foreach (new DirectoryIterator($vendors) as $vendor) {
            // if the item is an actual directory
            if ($vendor->isDir() && !$vendor->isDot()) {
                // loop through the vendor directory's package directories
                foreach (new DirectoryIterator($vendor->getPathname()) as $package) {
                    // if the item is an actual directory
                    if ($package->isDir() && ! $package->isDot()) {
                        // get the package's (expected) gravity directory pathname
                        $gravity = $this->implode(
                            $package->getPathname(),
                            $this->getGravityDirectoryName()
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
     * @return  SplFilInfo[]
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

    private function getProjectGravityDirectoryPathname(string $root): string
    {
        return $this->implode($root, $this->getGravityDirectoryName());
    }

    private function getVendorsDirectoryName(): string
    {
        return $this->directories['vendors'];
    }

    private function implode(string ...$segments): string
    {
        return implode(DIRECTORY_SEPARATOR, $segments);
    }

    private function isDirectory(string $pathname): bool
    {
        return is_readable($pathname) && is_dir($pathname);
    }
}
