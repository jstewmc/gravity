<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Project\Service;

use Jstewmc\Gravity\{
    Alias,
    Definition,
    Deprecation,
    File,
    Filesystem,
    Id,
    Import,
    Ns,
    Path,
    Root,
    Script,
    Service,
    Setting
};
use Jstewmc\Gravity\Project\Data\Project;

/**
  * Acts as if Gravity's services and settings were defined in a file.
 */
class Bootstrap
{
    private $namespace;

    public function __construct()
    {
        $this->namespace = new Ns\Data\Parsed();
    }

    public function __invoke(Project $project): Project
    {
        // add services and settings in dependency order
        $project->addService($this->getPathMerge());
        $project->addService($this->getPathParse());
        $project->addService($this->getPathResolve());
        $project->addService($this->getPathRender());

        $project->addService($this->getAliasParse());
        $project->addService($this->getAliasResolve());

        $project->addService($this->getDefinitionParse());
        $project->addService($this->getDefinitionResolve());

        $project->addService($this->getDeprecationParse());
        $project->addService($this->getDeprecationResolve());

        // TODO finish services


        return $project;
    }

    private function getDirectoryNames(): Setting\Data\Setting
    {
        $segments = ['jstewmc', 'gravity', 'directories'];
        $path     = new Path\Data\Setting($segments);
        $id       = new Id\Data\Setting($path);
        $setting = new Setting\Data\Setting($id, [
            'jstewmc' => [
                'gravity' => [
                    'directories' => [
                        'gravity' => '.gravity',
                        'vendors' => 'vendor'
                    ]
                ]
            ]
        ]);

        return $setting;
    }

    private function getSeparators(): Setting\Data\Setting
    {
        $segments = ['jstewmc', 'gravity', 'separators'];
        $path     = new Path\Data\Setting($segments);
        $id       = new Id\Data\Setting($path);
        $setting = new Setting\Data\Setting($id, [
            'jstewmc' => [
                'gravity' => [
                    'separators' => [
                        'service' => '\\',
                        'setting' => '.'
                    ]
                ]
            ]
        ]);

        return $setting;
    }

    private function getAliasParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'alias', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Alias\Service\Parse(Path\Service\Parse::class);
        }, $this->namespace);

        return $service;
    }

    private function getAliasResolve(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'alias', 'service', 'resolve'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Alias\Service\Resolve(Path\Service\Resolve::class);
        }, $this->namespace);

        return $service;
    }

    private function getDefinitionParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'definition', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Definition\Service\Parse(Path\Service\Parse::class);
        }, $this->namespace);

        return $service;
    }

    private function getDefinitionResolve(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'definition', 'service', 'resolve'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Definition\Service\Resolve(Path\Service\Resolve::class);
        }, $this->namespace);

        return $service;
    }

    private function getDeprecationParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'deprecation', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Deprecation\Service\Parse(Path\Service\Parse::class);
        }, $this->namespace);

        return $service;
    }

    private function getDeprecationResolve(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'deprecation', 'service', 'resolve'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Deprecation\Service\Resolve(Path\Service\Resolve::class);
        }, $this->namespace);

        return $service;
    }

    private function getDeprecationWarn(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'deprecation', 'service', 'warn'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getImportParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'import', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Import\Service\Parse(Path\Service\Parse::class);
        }, $this->namespace);

        return $service;
    }

    private function getPathMerge(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'path', 'service', 'merge'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getPathParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'path', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getPathResolve(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'path', 'service', 'resolve'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Path\Service\Resolve(Path\Service\Merge::class);
        }, $this->namespace);

        return $service;
    }

    private function getPathRender(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'path', 'service', 'render'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Path\Service\Render(
                Path\Service\Parse::class,
                Path\Service\Resolve::class
            );
        }, $this->namespace);

        return $service;
    }
}
