<?php

namespace Dwr\GameOfLive\Entity;

use Dwr\GameOfLive\Factory\CellFactory;

class Layout
{
    /**
     * @var array
     */
    private $cells;

    /**
     * Layout constructor.
     * @param array $layout
     */
    public function __construct(array $layout)
    {
        foreach ($layout as $key => $item) {
            $this->cells[] = CellFactory::createCell($item);
        }
    }

    /**
     * @return array
     */
    public function getCells()
    {
        return $this->cells;
    }
}