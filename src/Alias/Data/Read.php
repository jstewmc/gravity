<?php
/**
 * @copyright  2018 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\Gravity\Alias\Data;

class Read extends Alias
{
    public function __construct(string $source, string $destination)
    {
        parent::__construct($source, $destination);
    }

    public function getDestination(): string
    {
        return parent::getDestination();
    }

    public function getSource(): string
    {
        return parent::getSource();
    }
}
