<?php
/**
 * The file for Gravity
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\Alias\Data\Alias;
use Jstewmc\Gravity\Alias\Service\Parse as ParseAlias;
use Jstewmc\Gravity\Definition\Data\Definition;
use Jstewmc\Gravity\Definition\Service\Get as GetDefinition;
use Jstewmc\Gravity\Definition\Service\Parse as ParseDefinition;
use Jstewmc\Gravity\Deprecation\Data\Deprecation;
use Jstewmc\Gravity\Deprecation\Service\Parse as ParseDeprecation;
use Jstewmc\Gravity\Deprecation\Service\Warn;
use Jstewmc\Gravity\Filesystem\Service\Find as FindFilesystem;
use Jstewmc\Gravity\Filesystem\Service\Load as LoadFilesystem;
use Jstewmc\Gravity\Filesystem\Service\Read as ReadFilesystem;
use Jstewmc\Gravity\Id\Data\Id;
use Jstewmc\Gravity\Id\Data\Service as ServiceId;
use Jstewmc\Gravity\Id\Service\Find as FindId;
use Jstewmc\Gravity\Project\Data\Project;
use Jstewmc\Gravity\Service\Data\Service;

/**
 * The Gravity manager
 *
 * I coordinate the flow of services and settings between the user and the
 * project.
 *
 * @example  instantiate gravity (do this infrequently!)
 *   $g = new Jstewmc\Gravity\Manager();
 *
 * @example  define a service (using an anonymous function)
 *   $g->set('Foo\Bar\Baz', function () { return new StdClass(); });
 *
 * @example  define a setting
 *   $g->set('foo.bar.baz', 999);
 *
 * @example  get a service (returns instance of StdClass)
 *   $g->get('Foo\Bar\Baz');
 *
 * @example  get a setting (returns 999)
 *   $g->get('foo.bar.baz');
 *
 * @since  0.1.0
 */
class Manager
{
    /* !Private properties */

    /**
     * @var    FindId  the find-id service
     * @since  0.1.0
     */
    private $parseId;

    /**
     * @var    GetDefinition  the get-definition service
     * @since  0.1.0
     */
    private $getDefinition;

    /**
     * @var    ParseAlias  the parse-alias service
     * @since  0.1.0
     */
    private $parseAlias;

    /**
     * @var    ParseDefinition  the parse-definition service
     * @since  0.1.0
     */
    private $parseDefinition;

    /**
     * @var    ParseDeprecation  the parse-deprecation service
     * @since  0.1.0
     */
    private $parseDeprecation;

    /**
     * @var    Project  the project
     * @since  0.1.0
     */
    private $project;


    /* !Magic methods */

    /**
     * Called when the manager is constructed
     *
     * I'll bootstrap the service manager and load the project's instructions,
     * which are expensive. It's best to instantiate the manager once and
     * re-use it as much as possible!
     *
     * @since  0.1.0
     */
    public function __construct()
    {
        $this->bootstrap();

        $this->load();
    }

    /**
     * Called when the manager is treated like a function
     *
     * An alias for the get() method.
     *
     * @param   string  $id  a service or setting identifier
     * @return  mixed
     * @since   0.1.0
     */
    public function __invoke(string $id)
    {
        return $this->get($id);
    }


    /* !Public methods */

    /**
     * Adds an alias to the project
     *
     * Aliases help move things around, but in general, should be used lightly.
     * It's a better world if a service or setting has a single identifier.
     *
     * @example  Alias a service
     *    $g->alias('Foo\Bar\Baz');
     *
     * @example  Alias a setting
     *    $g->alias('foo.bar.baz');
     *
     * @param   string  $source       the alias' source identifier
     * @param   string  $destination  the alias' destination identifier
     * @return  self
     * @since   0.1.0
     */
    public function alias(string $source, string $destination): self
    {
        $alias = $this->parseAlias($source, $destination);

        $this->project->addAlias($alias);

        return $this;
    }

    /**
     * Adds a deprecation to the project
     *
     * When a deprecated service or setting is used, an E_USER_DEPRECATED error
     * is triggered.
     *
     * @example  deprecate a service
     *     $g->deprecate('Foo\Bar\Baz');
     *
     * @example  deprecate a setting with a replacement
     *     $g->deprecate('foo.bar.baz', 'foo.baz.qux');
     *
     * @param   string       $id           the deprecated identifier
     * @param   string|null  $replacement  the replacement identifier (optional)
     * @return  self
     * @since   0.1.0
     */
    public function deprecate(string $id, string $replacement = null): self
    {
        $deprecation = $this->parseDeprecation($id, $replacement);

        $this->project->addDeprecation($deprecation);

        return $this;
    }

    /**
     * Prepares the manager for garbage collection
     *
     * Most programming languages have trouble garbage collecting circular
     * references. In long-running processes like tests or workers, this can
     * cause a memory leak.
     *
     * I'll break any circular references that exist in the cache (e.g., any
     * service that has the manager injected into it) so PHP can garbage collect
     * this instance of the manager.
     *
     * @return  void
     * @since   0.1.0
     */
    public function destroy(): void
    {
        $this->getDefinition = null;
        unset($this->getDefinition);
    }

    /**
     * Returns a service or setting
     *
     * @example  get a service
     *     $g->get('Foo\Bar\Baz');
     *
     * @example  get a setting
     *     $g->get('foo.bar.baz');
     *
     * @param   string  $id  a service or setting identifier
     * @return  mixed
     * @since   0.1.0
     */
    public function get(string $id)
    {
        return $this->getDefinition($id, $this->project);
    }

    /**
     * Returns true if the service or setting exists
     *
     * @param   string  $id  a service or setting identifier
     * @return  bool
     * @since   0.1.0
     */
    public function has(string $id): bool
    {
        $id = $this->findId($id, $this->project);

        if ($id instanceof ServiceId) {
            $has = $this->project->hasService($id);
        } else {
            $has = $this->project->hasSetting($id);
        }

        return $has;
    }

    /**
     * Adds a service or setting to the project
     *
     * @example  set a service (using an anonoymous function)
     *     $g->set('Foo\Bar\Baz', function () { return new StdClass(); })
     *
     * @example  set a setting
     *     $g->set('foo.bar.baz', true);
     *
     * @param   string  $id     the service or setting's id
     * @param   mixed   $value  the service or setting's value
     * @return  self
     * @since   0.1.0
     */
    public function set(string $id, $value = null): self
    {
        $definition = $this->parseDefinition($id, $value);

        if ($definition instanceof Service) {
            $this->project->addService($definition);
        } else {
            $this->project->addSetting($definition);
        }

        return $this;
    }


    /* !Private methods */

    /**
     * Bootstraps the manager
     *
     * Because a service manager doesn't exist yet, I'll instantiate and inject
     * Gravity's dependencies.
     *
     * @return  void
     * @since   0.1.0
     */
    private function bootstrap(): void
    {
        // instantiate the "set-side" services
        $parseId = new \Jstewmc\Gravity\Id\Service\Parse();

        $parseService = new \Jstewmc\Gravity\Service\Service\Parse();
        $parseSetting = new \Jstewmc\Gravity\Setting\Service\Parse();

        $this->parseAlias       = new ParseAlias($parseId);
        $this->parseDeprecation = new ParseDeprecation($parseId);
        $this->parseDefinition  = new ParseDefinition(
            $parseId,
            $parseService,
            $parseSetting
        );

        // instantiate the cache (for now, just use a hash)
        $cache = new \Jstewmc\Gravity\Cache\Data\Hash();

        // instantiate the "get-side" services
        $warnDeprecation = new Warn();

        $resolveId    = new \Jstewmc\Gravity\Id\Service\Resolve($warnDeprecation);
        $this->findId = new \Jstewmc\Gravity\Id\Service\Find($parseId, $resolveId);

        $instantiateService = new \Jstewmc\Gravity\Service\Service\Instantiate($this);
        $getService         = new \Jstewmc\Gravity\Service\Service\Get($instantiateService);
        $getSetting         = new \Jstewmc\Gravity\Setting\Service\Get();

        $this->getDefinition = new GetDefinition(
            $this->findId,
            $getService,
            $getSetting,
            $cache
        );

        // initialize the project
        $this->project = new Project();

        return;
    }

    /**
     * Finds an identifier's final destination
     *
     * @param   string
     * @return  Id
     * @since   0.1.0
     */
    private function findId(string $id): Id
    {
        return ($this->findId)($id, $this->project);
    }

    /**
     * Returns a setting or service
     *
     * @param   string  $id  the setting or service id
     * @return  mixed
     * @since   0.1.0
     */
    private function getDefinition(string $id)
    {
        return ($this->getDefinition)($id, $this->project);
    }

    /**
     * Loads the Gravity manager from the filesystem
     *
     * Gravity expects to be installed via Composer, which should be a sensible
     * default. If not, it will leave the project empty.
     *
     * @return  void
     * @since   0.1.0
     */
    private function load(): void
    {
        $root = (new FindFilesystem())();

        if (!$root) {
            return;
        }

        $filesystem = (new ReadFilesystem())($root);

        (new LoadFilesystem())($filesystem, $this);

        return;
    }

    /**
     * Parses an alias
     *
     * @param   string  $source       the source id
     * @param   string  $destination  the destination id
     * @return  Alias
     * @since   0.1.0
     */
    private function parseAlias(string $source, string $destination): Alias
    {
        return ($this->parseAlias)($source, $destination);
    }

    /**
     * Parses a setting or service definition
     *
     * @param   string  $id     the setting or service id
     * @param   mixed   $value  the definition's value
     * @return  Definition
     * @since   0.1.0
     */
    private function parseDefinition(string $id, $value): Definition
    {
        return ($this->parseDefinition)($id, $value);
    }

    /**
     * Parses a deprecation
     *
     * @param   string       $id           the deprecated id
     * @param   string|null  $replacement  the id's replacement (optional)
     * @return  Deprecation
     * @since   0.1.0
     */
    private function parseDeprecation(
        string $id,
        string $replacement = null
    ): Deprecation {
        return ($this->parseDeprecation)($id, $replacement);
    }
}
