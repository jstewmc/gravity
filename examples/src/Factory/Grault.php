<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Factory;

use Jstewmc\Gravity\Example\Service\Grault as GraultService;
use Jstewmc\Gravity\Manager\Data\Manager;
use Jstewmc\Gravity\Factory as FactoryInterface;

class Grault implements FactoryInterface
{
    public function __invoke(Manager $g): GraultService
    {
        return new GraultService();
    }
}
