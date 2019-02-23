<?php
/**
 * @copyright  2018 Jack Clayton
 * @license  MIT
 */

namespace Jstewmc\Gravity\Filesystem\Service;

use DirectoryIterator;
use Jstewmc\Gravity\Filesystem\Data\Traversed;
use Jstewmc\Gravity\Root\Data\Root;
use Psr\Log\LoggerInterface as Logger;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use function array_values,
    count,
    implode,
    is_dir,
    is_file,
    is_readable,
    iterator_to_array,
    number_format,
    strpos;

class Traverse
{
    private $directories;

    /**
     * @param  string[]  $directories  an array of directory names with keys
     *   "gravity" and "vendors"
     */
    public function __construct(array $directories, Logger $logger)
    {
        $this->directories = $directories;
        $this->logger      = $logger;
    }

    /**
     * Project files take precedence over package files so the user's settings
     * win, and local environment files should take precedence over global
     * environment files so the local enviornment wins.
     */
    public function __invoke(Root $root, string $environment): Traversed
    {
        $this->before($root, $environment);

        $pathnames = $this->getPackageGravityDirectoryPathnames($root);

        if ($pathnames) {
            $packageGlobal = $this->getPackageGlobalFiles($pathnames);
            $packageLocal  = $this->getPackageLocalFiles($pathnames, $environment);
        }

        $pathname = $this->getProjectGravityDirectoryPathname($root);

        if ($pathname) {
            $projectGlobal = $this->getProjectGlobalFiles($pathname);
            $projectLocal  = $this->getProjectLocalFiles($pathname, $environment);
        }

        $files = array_merge(
            $packageGlobal ?? [],
            $projectGlobal ?? [],
            $packageLocal ?? [],
            $projectLocal ?? []
        );

        $filesystem = new Traversed($files);

        $this->after($files);

        return $filesystem;
    }


    private function after(array $files): void
    {
        $total = number_format(count($files));

        $this->logger->info("Found $total files.");
    }

    private function before(string $root, string $environment = null): void
    {
        $message = "Starting traversal of $root";

        if ($environment) {
            $message .= " in $environment";
        }

        $message .= '...';

        $this->logger->info($message);
    }

    /**
     * @return  SplFileInfo[]
     */
    private function getEnvironmentFiles(string $gravity, string $environment): array
    {
        $files = [];

        // get the expected file and directory pathnames
        $file      = $this->implode($gravity, 'environments', "$environment.php");
        $directory = $this->implode($gravity, 'environments', $environment);

        if ($this->isFile($file)) {
            $files[] = new SplFileInfo($file);
        } elseif ($this->isDirectory($directory)) {
            $files = $this->getLocalFiles($directory);
        }

        return $files;
    }

    /**
     * Recursively lists all non-environment files in a gravity directory
     *
     * @return  SplFileInfo[]
     */
    private function getGlobalFiles(string $directory): array
    {
        $files = [];

        $rdi = new RecursiveDirectoryIterator(
            $directory,
            RecursiveDirectoryIterator::SKIP_DOTS
        );

        $rii = new RecursiveIteratorIterator(
            $rdi,
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        // include files that do not start with the environments directory
        $environments = $this->implode($directory, 'environments');

        foreach ($rii as $item) {
            if (strpos($item->getPathname(), $environments) !== 0) {
                $files[] = $item;
            }
        }

        return $files;
    }

    private function getGravityDirectoryName(): string
    {
        return $this->directories['gravity'];
    }

    /**
     * Recursively lists all files in an environment directory
     *
     * @return  SplFileInfo[]
     */
    private function getLocalFiles(string $directory)
    {
        $rdi = new RecursiveDirectoryIterator(
            $directory,
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
    private function getPackageGlobalFiles(array $directories): array
    {
        $files = [];

        foreach ($directories as $directory) {
            $files = array_merge($files, $this->getGlobalFiles($directory));
        }

        return $files;
    }

    /**
     * @return  SplFileInfo[]
     */
    private function getPackageLocalFiles(
        array  $directories,
        string $environment = null
    ): array {
        $files = [];

        foreach ($directories as $directory) {
            $files = array_merge(
                $files,
                $this->getEnvironmentFiles($directory, $environment)
            );
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
    private function getProjectGlobalFiles(string $directory): array
    {
        return $this->getGlobalFiles($directory);
    }

    private function getProjectGravityDirectoryPathname(string $root): ?string
    {
        $pathname = $this->implode($root, $this->getGravityDirectoryName());

        return $this->isDirectory($pathname) ? $pathname : null;
    }

    private function getProjectLocalFiles(string $directory, string $environment): array
    {
        return $this->getEnvironmentFiles($directory, $environment);
    }

    private function getVendorsDirectoryName(): string
    {
        return $this->directories['vendors'];
    }

    private function implode(string ...$segments): string
    {
        return implode(DIRECTORY_SEPARATOR, $segments);
    }

    private function isFile(string $pathname): bool
    {
        return is_readable($pathname) && is_file($pathname);
    }

    private function isDirectory(string $pathname): bool
    {
        return is_readable($pathname) && is_dir($pathname);
    }
}
