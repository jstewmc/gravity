<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity;

use Jstewmc\Gravity\Manager;

interface Factory
{
    public function __invoke(Manager $g);
}
