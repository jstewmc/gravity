<?php
/**
 * The file for the filesystem
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Filesystem\Data;

use SplFileInfo;

/**
 * A filesystem has many files
 *
 * @since  0.1.0
 */
class Filesystem
{
    /* !Public constants */

    /**
     * @var    string  the name of the Gravity directory
     * @since  0.1.0
     */
    public const DIRECTORY_NAME_GRAVITY = '.gravity';

    /**
     * @var    string  the name of the Composer directory
     * @since  0.1.0
     */
    public const DIRECTORY_NAME_VENDORS = 'vendor';


    /* !Private properties */

    /**
     * @var    SplFileInfo[]  the filesystem's files
     * @since  0.1.0
     */
    private $files;


    /* !Magic methods */

    /**
     * Called when the filesystem is constructed
     *
     * @param  SplFileInfo[]  $files  the filesystem's files
     * @since  0.1.0
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }


    /* !Get methods */

    /**
     * Returns the filesystem's files
     *
     * @return  SplFileInfo[]
     * @since   0.1.0
     */
    public function getFiles(): array
    {
        return $this->files;
    }
}
