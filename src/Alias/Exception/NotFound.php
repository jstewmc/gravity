<?php
/**
 * The file for an alias not found exception
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Exception;

use Jstewmc\Gravity\Id\Data\Id;

/**
 * Thrown when an alias is not found
 *
 * @since  0.1.0
 */
class NotFound extends Exception
{
	/* !Magic methods */

	/**
	 * Called when the exception is constructed
	 *
	 * @param  Id  $id  the identifier not found
	 * @since  0.1.
	 */
	public function __construct(Id $id)
	{
		parent::__construct($id);

		$this->message = "Alias '$id' not found";
	}
}
