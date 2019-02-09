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
    Cache,
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
 * Not short, but it's as if Gravity bootstrapped itself.
 */
class Bootstrap
{
    private $namespace;

    public function __construct()
    {
        $this->namespace = new Ns\Data\Parsed();
    }

    public function __invoke(Project $project, array $options = []): Project
    {
        $defaults = [
            'cache' => null
        ];

        $options = array_merge($defaults, $options);

        $project = $this->bootstrapServices($project, $options);

        $project = $this->bootstrapSettings($project, $options);

        return $project;
    }

    private function bootstrapServices(Project $project, array $options): Project
    {
        $project->addService($this->getAliasParse());
        $project->addService($this->getAliasResolve());

        $project->addService($this->getDefinitionParse());
        $project->addService($this->getDefinitionResolve());

        $project->addService($this->getDeprecationParse());
        $project->addService($this->getDeprecationResolve());
        $project->addService($this->getDeprecationWarn());

        $project->addService($this->getCache($options['cache']));

        $project->addService($this->getFileClose());
        $project->addService($this->getFileGet());
        $project->addService($this->getFileOpen());
        $project->addService($this->getFileParse());
        $project->addService($this->getFileRead());
        $project->addService($this->getFileRun());

        $project->addService($this->getFilesystemLoad());
        $project->addService($this->getFilesystemTraverse());

        $project->addService($this->getIdFollow());
        $project->addService($this->getIdGet());
        $project->addService($this->getIdRender());

        $project->addService($this->getImportParse());

        $project->addService($this->getNamespaceClose());
        $project->addService($this->getNamespaceParse());

        $project->addService($this->getPathMerge());
        $project->addService($this->getPathParse());
        $project->addService($this->getPathResolve());
        $project->addService($this->getPathRender());

        $project->addService($this->getProjectHydrate());

        $project->addService($this->getRootFind());

        $project->addService($this->getScriptClose());
        $project->addService($this->getScriptInterpret());
        $project->addService($this->getScriptParse());
        $project->addService($this->getScriptResolve());

        $project->addService($this->getServiceGet());
        $project->addService($this->getServiceInstantiate());
        $project->addService($this->getServiceInterpret());

        $project->addService($this->getSettingGet());
        $project->addService($this->getSettingInterpret());

        return $project;
    }

    private function bootstrapSettings(Project $project): Project
    {
        $project->addSetting($this->getDirectories());
        $project->addSetting($this->getSeparators());

        return $project;
    }

    private function getAliasParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'alias', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Alias\Service\Parse(
                $this->get(Path\Service\Parse::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getAliasResolve(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'alias', 'service', 'resolve'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Alias\Service\Resolve(
                $this->get(Path\Service\Resolve::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getCache($instance = null): Service\Data\Service
    {
        if ($instance === null) {
            $instance = new Cache\Data\Hash();
        }

        $segments = ['jstewmc', 'gravity', 'cache'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Instance($id, $instance);

        return $service;
    }

    private function getDefinitionParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'definition', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Definition\Service\Parse(
                $this->get(Path\Service\Parse::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getDefinitionResolve(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'definition', 'service', 'resolve'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Definition\Service\Resolve(
                $this->get(Path\Service\Resolve::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getDeprecationParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'deprecation', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Deprecation\Service\Parse(
                $this->get(Path\Service\Parse::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getDeprecationResolve(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'deprecation', 'service', 'resolve'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Deprecation\Service\Resolve(
                $this->get(Path\Service\Resolve::class)
            );
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

    private function getDirectories(): Setting\Data\Setting
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

    private function getFileClose(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'file', 'service', 'close'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new File\Service\Close(
                $this->get(Ns\Service\Close::class),
                $this->get(Script\Service\Close::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getFileGet(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'file', 'service', 'get'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new File\Service\Get(
                $this->get(File\Service\Open::class),
                $this->get(File\Service\Read::class),
                $this->get(File\Service\Close::class),
                $this->get(File\Service\Parse::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getFileOpen(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'file', 'service', 'open'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getFileParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'file', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new File\Service\Parse(
                $this->get(Ns\Service\Parse::class),
                $this->get(Script\Service\Parse::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getFileRead(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'file', 'service', 'read'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getFileRun(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'file', 'service', 'run'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new File\Service\Run(
                $this->get(Script\Service\Resolve::class),
                $this->get(Script\Service\Interpret::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getFilesystemLoad(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'filesystem', 'service', 'load'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Filesystem\Service\Load(
                $this->get(File\Service\Get::class),
                $this->get(File\Service\Run::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getFilesystemTraverse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'filesystem', 'service', 'traverse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Filesystem\Service\Traverse(
                $this->get('jstewmc.gravity.directories')
            );
        }, $this->namespace);

        return $service;
    }

    private function getIdFollow(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'id', 'service', 'follow'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Id\Service\Follow(
                $this->get(Deprecation\Service\Warn::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getIdGet(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'id', 'service', 'get'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Id\Service\Get(
                $this->get(Id\Service\Render::class),
                $this->get(Id\Service\Follow::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getIdRender(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'id', 'service', 'render'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Id\Service\Render(
                $this->get(Path\Service\Parse::class),
                $this->get(Path\Service\Resolve::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getImportParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'import', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Import\Service\Parse(
                $this->get(Path\Service\Parse::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getNamespaceClose(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'ns', 'service', 'close'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getNamespaceParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'ns', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Ns\Service\Parse(
                $this->get(Path\Service\Parse::class),
                $this->get(Import\Service\Parse::class)
            );
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
            return new Path\Service\Resolve(
                $this->get(Path\Service\Merge::class)
            );
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
                $this->get(Path\Service\Parse::class),
                $this->get(Path\Service\Resolve::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getProjectHydrate(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'project', 'service', 'hydrate'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getRootFind(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'root', 'service', 'find'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Root\Service\Find(
                $this->get('jstewmc.gravity.directories.vendors')
            );
        }, $this->namespace);

        return $service;
    }

    private function getScriptClose(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'script', 'service', 'close'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getScriptInterpret(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'script', 'service', 'interpret'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Script\Service\Interpret(
                $this->get(Service\Service\Interpret::class),
                $this->get(Setting\Service\Interpret::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getScriptParse(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'script', 'service', 'parse'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Script\Service\Parse(
                $this->get(Alias\Service\Parse::class),
                $this->get(Definition\Service\Parse::class),
                $this->get(Deprecation\Service\Parse::class)
            );
        }, $this->namespace);

        return $service;
    }

    private function getScriptResolve(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'script', 'service', 'resolve'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Script\Service\Resolve(
                $this->get(Alias\Service\Resolve::class),
                $this->get(Definition\Service\Resolve::class),
                $this->get(Deprecation\Service\Resolve::class)
            );
        }, $this->namespace);

        return $service;
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

    private function getServiceGet(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'service', 'service', 'get'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Service\Service\Get(
                $this->get(Service\Service\Instantiate::class),
                $this->get('Jstewmc\Gravity\Cache')
            );
        }, $this->namespace);

        return $service;
    }

    private function getServiceInstantiate(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'service', 'service', 'instantiate'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getServiceInterpret(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'service', 'service', 'interpret'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }

    private function getSettingGet(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'setting', 'service', 'get'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Fx($id, function () {
            return new Setting\Service\Get(
                $this->get('Jstewmc\Gravity\Cache')
            );
        }, $this->namespace);

        return $service;
    }

    private function getSettingInterpret(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'setting', 'service', 'interpret'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

        return $service;
    }
}
