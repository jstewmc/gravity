<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Service;

use Jstewmc\Gravity\Ns\Data\Parsed as Ns;
use Jstewmc\Gravity\Script\Data\{Interpreted, Resolved};
use Jstewmc\Gravity\Service\Service\Interpret as InterpretService;
use Jstewmc\Gravity\Setting\Service\Interpret as InterpretSetting;

class Interpret
{
    private $interpretService;

    private $interpretSetting;

    public function __construct(
        InterpretService $interpretService,
        InterpretSetting $interpretSetting
    ) {
        $this->interpretService = $interpretService;
        $this->interpretSetting = $interpretSetting;
    }

    public function __invoke(Resolved $script, Ns $namespace): Interpreted
    {
        $services = $this->interpretServices($script->getDefinitions(), $namespace);

        $settings = $this->interpretSettings($script->getDefinitions());

        $script = (new Interpreted())
            ->setAliases($script->getAliases())
            ->setDeprecations($script->getDeprecations())
            ->setRequirements($script->getRequirements())
            ->setServices($services)
            ->setSettings($settings);

        return $script;
    }

    private function interpretServices(array $definitions, Ns $namespace): array
    {
        $services = [];

        foreach ($definitions as $definition) {
            if ($definition->isService()) {
                $services[] = ($this->interpretService)($definition, $namespace);
            }
        }

        return $services;
    }

    private function interpretSettings(array $definitions)
    {
        $settings = [];

        foreach ($definitions as $definition) {
            if ($definition->isSetting()) {
                $settings[] = ($this->interpretSetting)($definition);
            }
        }

        return $settings;
    }
}
