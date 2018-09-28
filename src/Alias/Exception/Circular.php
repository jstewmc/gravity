<?php
/**
 * The file for a circular alias exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

use Jstewmc\Gravity\Id\Data\Id;

/**
 * Thrown when an alias is circular
 *
 * @since  0.1.0
 */
class Circular extends Exception
{
	/* !Magic methods */

	/**
	 * Called when the exception is constructed
	 *
	 * @param  Id  $id  the circular identifier
	 * @since  0.1.
	 */
	public function __construct(Id $id)
	{
		parent::__construct($id);
		
		$this->message = "Circular alias for '$id'";
	}
}
