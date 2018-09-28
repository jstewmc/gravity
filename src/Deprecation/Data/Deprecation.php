<?php
/**
 * The file for a setting or service deprecation
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Deprecation\Data;

use Jstewmc\Gravity\Deprecation\Exception\Circular;
use Jstewmc\Gravity\Id\Data\Id;


/**
 * A setting or service deprecation
 *
 * Users will be warned when using a deprecated alias, service, or setting. A
 * deprecation may define a replacement which will be included in the error
 * message.
 *
 * @since  0.1.0
 */
abstract class Deprecation
{
	/* !Private properties */

	/**
	 * @var    Id  the deprecated identifier
	 * @since  0.1.0
	 */
	private $id;

	/**
	 * @var    Id|null  the replacement identifier (optional)
	 * @since  0.1.0
	 */
	private $replacement;


	/* !Magic methods */

	/**
	 * Called when the deprecation is constructed
	 *
	 * @param   Id       $id   the deprecated identifier
	 * @param   Id|null  $replacement  the replacement identifier (optional)
	 * @since   0.1.0
	 */
	public function __construct(Id $id, ?Id $replacement)
	{
		$this->identifier  = $id;
		$this->replacement = $replacement;
	}


	/* !Get methods */

	/**
	 * Returns the deprecated identifier
	 *
	 * @return  Id
	 * @since   0.1.0
	 */
	public function getId(): Id
	{
		return $this->identifier;
	}

	/**
	 * Returns the deprecation's replacement
	 *
	 * @return  Id|null
	 * @since   0.1.0
	 */
	public function getReplacement(): ?Id
	{
		return $this->replacement;
	}


	/* !Set methods */

	/**
	 * Sets the deprecation's replacement
	 *
	 * @param   Id  $replacement
	 * @return  self
	 * @since   0.1.0
	 */
	public function setReplacement(Id $replacement): self
	{
		$this->replacement = $replacement;

		return $this;
	}


	/* !Public methods */

	/**
	 * Returns true if a replacement exists
	 *
	 * @return  bool
	 * @since   0.1.0
	 */
	public function hasReplacement(): bool
	{
		return $this->replacement !== null;
	}
}
