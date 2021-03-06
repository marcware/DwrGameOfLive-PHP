<?php
declare(strict_types=1);

namespace Dwr\GameOfLive\Validator;

use Dwr\GameOfLive\Entity\Board;
use Dwr\GameOfLive\Entity\Layout;
use Dwr\GameOfLive\Exception\BadTemplateStructureException;

final class TemplateValidator implements ValidatorInterface
{
    /**
     * @var Board
     */
    private $board;

    /**
     * @var Layout
     */
    private $layout;

    /**
     * TemplateValidator constructor.
     * @param array $template
     * @throws BadTemplateStructureException
     */
    public function __construct(array $template)
    {
        if (! $this->isStructureCorrect($template)) {
            throw new BadTemplateStructureException('Wrong json template structure.');
        }

        $this->board = $template['board'];
        $this->layout = $template['layout'];
    }

    /**
     * @param array $template
     * @return bool
     */
    private function isStructureCorrect(array $template)
    {
        if ($this->hasTemplateRequiredNodes($template)) {
            if ($this->hasBoardRequiredNodes($template['board'])) {
                foreach ($template['layout'] as $position) {
                    if (! $this->isPositionInsideLayout($position)) {
                        return false;
                    }
                }
                return true;
            }
        }
    }

    /**
     * @param array $template
     * @return bool
     */
    private function hasTemplateRequiredNodes(array $template) : bool
    {
        return array_key_exists('board', $template) && array_key_exists('layout', $template);
    }

    /**
     * @param array $board
     * @return bool
     */
    private function hasBoardRequiredNodes(array $board) : bool
    {
        return array_key_exists('length', $board) && array_key_exists('width', $board);
    }

    /**
     * @param array $position
     * @return bool
     */
    private function isPositionInsideLayout(array $position) : bool
    {
        return array_key_exists('lat', $position) && array_key_exists('lon', $position);
    }

    /**
     * @return bool
     */
    public function isValid() : bool
    {
        if ($this->isCellLatitudeLesserOrEqualsBoardWidth() &&
            $this->isCellLongitudeLesserOrEqualsBoardLength()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isCellLatitudeLesserOrEqualsBoardWidth()
    {
        $width = $this->board['width'];

        foreach ($this->layout as $cell) {
            if ($cell['lat'] >= $width) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    private function isCellLongitudeLesserOrEqualsBoardLength()
    {
        $length = $this->board['length'];

        foreach ($this->layout as $cell) {
            if ($cell['lon'] >= $length) {
                return false;
            }
        }

        return true;
    }
}
