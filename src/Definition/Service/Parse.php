<?php
/**
 * The file for the parse-definition service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Definition\Service;

use Jstewmc\Gravity\Definition\Data\Definition;
use Jstewmc\Gravity\Id\Data\{
    Id,
    Service as ServiceId,
    Setting as SettingId
};
use Jstewmc\Gravity\Id\Service\Parse as ParseId;
use Jstewmc\Gravity\Service\Data\Service as ServiceDefinition;
use Jstewmc\Gravity\Service\Service\Parse as ParseService;
use Jstewmc\Gravity\Setting\Data\Setting as SettingDefinition;
use Jstewmc\Gravity\Setting\Service\Parse as ParseSetting;

/**
 * The parse-definition service
 *
 * @since  0.1.0
 */
class Parse
{
    /* !Private properties */

    /**
     * @var    ParseId  the parse-identifier service
     * @since  0.1.0
     */
    private $parseId;

    /**
     * @var    ParseService  the parse-service service
     * @since  0.1.0
     */
    private $parseService;

    /**
     * @var    ParseSetting  the parse-setting service
     * @since  0.1.0
     */
    private $parseSetting;


    /* !Magic methods */

    /**
     * Called when the service is constructed
     *
     * @param  ParseId  $parseId  the parse-identifier service
     * @param  ParseService     $parseService     the parse-service service
     * @param  ParseSetting     $parseSetting     the parse-setting service
     * @since  0.1.0
     */
    public function __construct(
        ParseId  $parseId,
        ParseService     $parseService,
        ParseSetting     $parseSetting
    ) {
        $this->parseId = $parseId;
        $this->parseService    = $parseService;
        $this->parseSetting    = $parseSetting;
    }

    /**
     * Called when the service is treated like a function
     *
     * @param   string  $id  the definition's identifier
     * @param   mixed   $value       the definition's value
     * @return  Definition
     * @since   0.1.0
     */
    public function __invoke(string $id, $value): Definition
    {
        $id = $this->parseId($id);

        if ($id instanceof ServiceId) {
            $definition = $this->parseService($id, $value);
        } else {
            $definition = $this->parseSetting($id, $value);
        }

        return $definition;
    }


    /* !Private methods */

    /**
     * Parses an identifier
     *
     * @param   string  $id  the identifier to parse
     * @return  Id
     * @since   0.1.0
     */
    private function parseId(string $id): Id
    {
        return ($this->parseId)($id);
    }

    /**
     * Parses a service definition
     *
     * @param   ServiceId  $id  the service's identifier
     * @param   mixed              $value       the service's definition
     * @return  ServiceDefinition
     * @since   0.1.0
     */
    private function parseService(ServiceId $id, $value): ServiceDefinition
    {
        return ($this->parseService)($id, $value);
    }

    /**
     * Parses a setting definition
     *
     * @param   SettingId  $id  the setting's identifier
     * @param   mixed              $value       the setting's definition
     * @return  SettingDefinition
     * @since   0.1.0
     */
    private function parseSetting(SettingId $id, $value): SettingDefinition
    {
        return ($this->parseSetting)($id, $value);
    }
}
