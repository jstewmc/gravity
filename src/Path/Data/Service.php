<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Path\Data;

class Service extends Path
{
	public function __construct(array $segments)
	{
		self::$separator = '\\';

		parent::__construct($segments);
	}
}
