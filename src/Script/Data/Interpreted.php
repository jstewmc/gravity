<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Script\Data;

class Interpreted extends Script
{
    private $services = [];

    private $settings = [];

    public function getServices(): array
    {
        return $this->services;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function setServices(array $services): self
    {
        $this->services = $services;

        return $this;
    }

    public function setSettings(array $settings): self
    {
        $this->settings = $settings;

        return $this;
    }
}
