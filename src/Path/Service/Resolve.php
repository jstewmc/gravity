<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Service;

use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Path\Data\{
    Path,
    Service as ServicePath,
    Setting as SettingPath
};

/**
 * Resolves a local path in a namespace into a global identifier
 */
class Resolve
{
    private $merge;

    public function __construct(Merge $merge)
    {
        $this->merge = $merge;
    }

    /**
     * There are three scenarios:
     *
     *     1. If the namespace is empty or the path is fully qualified, the path
     *        is treated like an identifier and returned as-is.
     *     2. If the namespace has a name or the path starts with the name of an
     *        imported namespace, the path is prefixed.
     *     3. Otherwise, the path is an identifier, and it is returned as-is.
     */
    public function __invoke(Path $path, Ns $namespace): Id
    {
        if (!$namespace->isEmpty() || !$this->isFullyQualified($path)) {
            if ($this->isRelative($path, $namespace)) {
                $path = $this->resolveRelative($path, $namespace);
            } elseif ($namespace->hasName()) {
                $path = $this->resolveNamespace($path, $namespace);
            }
        }

        if ($path instanceof ServicePath) {
            $id = new ServiceId($path);
        } else {
            $id = new SettingId($path);
        }

        return $id;
    }


    /* !Private properties */

    /**
     * A fully-qualified path starts with a leading separator
     */
    private function isFullyQualified(Path $path): bool
    {
        return $path->hasLeadingSeparator();
    }

    /**
     * A relative path starts with the name of an imported namespace
     */
    private function isRelative(Path $path, Ns $namespace): bool
    {
        return $namespace->hasImport($path->getFirstSegment());
    }

    private function merge(Path $a, Path $b): Path
    {
        return ($this->merge)($a, $b);
    }

    /**
     * A naked path in a namespace is prefixed with namespace name
     */
    private function resolveNamespace(Path $path, Ns $namespace): Path
    {
        return $this->merge($namespace->getName(), $path);
    }

    /**
     * A relative path is prefixed with import's path
     */
    private function resolveRelative(Path $path, Ns $namespace): Path
    {
        $import = $namespace->getImport($path->getFirstSegment());

        // shift the first segment off the path (or, alternatively, shift the
        // last segment off the import's path), because they're shared
        $path->shiftFirstSegment();

        return $this->merge($import->getPath(), $path);
    }
}
