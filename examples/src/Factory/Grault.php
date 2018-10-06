<?php
/**
 * The file for the example factory
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Example\Factory;

use Jstewmc\Gravity\Example\Service\Grault as GraultService;
use Jstewmc\Gravity\Manager;
use Jstewmc\Gravity\Factory as FactoryInterface;

class Grault implements FactoryInterface
{
    public function __invoke(Manager $g): GraultService
    {
        return new GraultService();
    }
}
