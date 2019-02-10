<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\Manager\Data\Manager;

interface Factory
{
    public function __invoke(Manager $g);
}
