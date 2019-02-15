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
use Jstewmc\Gravity\Cache\Data\Cache as CacheInterface;
use Jstewmc\Gravity\Project\Data\Project;
use Psr\Log\LoggerInterface;

/**
 * Excludes services defined during bootstrap (e.g., Path, Id, GetX, etc).
 */
class Bootstrap
{
    private $namespace;

    public function __construct()
    {
        $this->namespace = new Ns\Data\Parsed();
    }

    public function __invoke(Project $project, LoggerInterface $logger): Project
    {
        $project = $this->bootstrapConfig($project, $logger);

        $project = $this->bootstrapServices($project);

        $project = $this->bootstrapSettings($project);

        return $project;
    }

    private function bootstrapConfig(Project $project, LoggerInterface $logger): Project
    {
        $project->addService($this->getLogger($logger));

        return $project;
    }

    private function bootstrapServices(Project $project): Project
    {
        $project->addService($this->getAliasParse());
        $project->addService($this->getAliasResolve());

        $project->addService($this->getDefinitionParse());
        $project->addService($this->getDefinitionResolve());

        $project->addService($this->getDeprecationParse());
        $project->addService($this->getDeprecationResolve());
        $project->addService($this->getDeprecationWarn());

        $project->addService($this->getFileClose());
        $project->addService($this->getFileGet());
        $project->addService($this->getFileOpen());
        $project->addService($this->getFileParse());
        $project->addService($this->getFileRead());
        $project->addService($this->getFileRun());

        $project->addService($this->getFilesystemLoad());
        $project->addService($this->getFilesystemTraverse());

        $project->addService($this->getImportParse());

        $project->addService($this->getNamespaceClose());
        $project->addService($this->getNamespaceParse());

        $project->addService($this->getProjectHydrate());

        $project->addService($this->getScriptClose());
        $project->addService($this->getScriptInterpret());
        $project->addService($this->getScriptParse());
        $project->addService($this->getScriptResolve());

        $project->addService($this->getServiceInterpret());

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
                $this->get(File\Service\Run::class),
                $this->get('Jstewmc\Gravity\Logger')
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
                $this->get('jstewmc.gravity.directories'),
                $this->get('jstewmc\gravity\logger')
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

    private function getLogger(LoggerInterface $logger): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'logger'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Instance($id, $logger);

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

    private function getProjectHydrate(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'project', 'service', 'hydrate'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

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

    private function getServiceInterpret(): Service\Data\Service
    {
        $segments = ['jstewmc', 'gravity', 'service', 'service', 'interpret'];
        $path     = new Path\Data\Service($segments);
        $id       = new Id\Data\Service($path);
        $service  = new Service\Data\Newable($id);

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
