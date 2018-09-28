<?php
/**
 * The file for a setting
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Setting\Data;

use Jstewmc\Gravity\Definition\Data\Definition;
use Jstewmc\Gravity\Id\Data\Setting as Id;

/**
 * A setting
 *
 * @since  0.1.0
 */
class Setting extends Definition
{
    /* !Private properties */

    /**
     * @var    mixed[]  the setting's array
     * @since  0.1.0
     */
    private $array;


    /* !Magic methods */

    /**
     * Called when the setting is constructed
     *
     * @param  Id  $id  the setting's identifier
     * @param  array       $array       the setting's consolidated array
     * @since  0.1.0
     */
    public function __construct(Id $id, array $array)
    {
        parent::__construct($id);

        $this->{"array"} = $array;
    }


    /* !Get methods */

    /**
     * Returns the setting's value
     *
     * @return  array
     * @since   0.1.0
     */
    public function getArray(): array
    {
        return $this->{"array"};
    }
}
