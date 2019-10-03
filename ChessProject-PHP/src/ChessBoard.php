<?php

namespace SolarWinds\Chess;

use SolarWinds\Chess\Pieces\PiecesInterface;
use SolarWinds\Chess\Settings\PieceColorEnum;
use SolarWinds\Chess\Settings\ChessBoardSettingsInterface;

class ChessBoard 
{

    /**  @var array Multidimentional array with the board cells */
    private $boardCells;

    /** @var array Log with the game moves */
    private $movementsLog = [];

    /** @var PieceColorEnum The player who will do the next turn */
    private $nextMove;

    /**
     * Set all board cells to NULL (empty)
     * YES: the board size is not constant in this crazy case https://en.wikipedia.org/wiki/Chess_on_a_Really_Big_Board
     * 
     * @param ChessBoardSettingsInterface $Settings
     * @param PieceColorEnum $nextMove
     */
    public function __construct(ChessBoardSettingsInterface $Settings, PieceColorEnum $nextMove)
    {
        $this->setNextMove($nextMove); // Allow the first player to make a move.

        $this->boardCells = array_fill(
            0, 
            $Settings::getMaxBoardHeight(), 
            array_fill(
                0, 
                $Settings::getMaxBoardWidth(), 
                NULL
            )
        );
    }

    /**
     * Set the next move.
     *
     * @param PieceColorEnum $nextMove
     * @return void
     */
    public function setNextMove(PieceColorEnum $nextMove)
    {
        $this->nextMove = $nextMove;
    }

    /**
     * Add `piece` to a `board` `cell`
     *
     * @param PiecesInterface $Piece
     * @return boolean - FALSE only of the boa
     */
    public function setPieceToCell(PiecesInterface $Piece): bool
    {
        $xCoordinate = $Piece->getXCoordinate();
        $yCoordinate = $Piece->getYCoordinate();

        if ($this->boardCellExists($xCoordinate, $yCoordinate)) {
            $this->boardCells[$xCoordinate][$yCoordinate] = $Piece;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Clear the cell after the piece is moved.
     *
     * @param integer $xCoordinate
     * @param integer $yCoordinate
     */
    public function setEmptyCell(int $xCoordinate, int $yCoordinate)
    {
        if ($this->boardCellExists($xCoordinate, $yCoordinate)) {
            $this->boardCells[$xCoordinate][$yCoordinate] = NULL;
        }
    }

    /**
     * Get `cell` name by given coordinates
     *
     * @param int $xCoordinate
     * @param int $yCoordinate
     * @return string|null
     */
    public function getCellNameByCoordinates(int $xCoordinate, int $yCoordinate): ?string
    {
        $alphabet = range('A', 'Z');
        if ($this->boardCellExists($xCoordinate, $yCoordinate)) {
            return $alphabet[$xCoordinate] . ($yCoordinate + 1);
        }
        return NULL;
    }

    /**
     * Get cell piece by the cell name.
     * Note the cell could be empty (NULL).
     *
     * @param string $cellName
     * @return PiecesInterface|null
     */
    public function getCellPieceByCellName(string $cellName): ?PiecesInterface
    {
        $alphabetFliped = array_flip(range('A', 'Z'));
        $xCoordinate = $alphabetFliped[$cellName[0]];
        $yCoordinate = (int)substr($cellName,1) - 1;

        return $this->getCellPieceByCoordinates($xCoordinate, $yCoordinate);
    }

    /**
     * Get `cell` `piece` by coordinates.
     * Note the `cell` could be empty (NULL).
     *
     * @param integer $xCoordinate
     * @param integer $yCoordinate
     * @return PiecesInterface|null
     */
    public function getCellPieceByCoordinates(int $xCoordinate, int $yCoordinate): ?PiecesInterface
    {
        if ($this->boardCellExists($xCoordinate, $yCoordinate)) {
            return $this->boardCells[$xCoordinate][$yCoordinate];
        }
        return NULL;
    }

    /**
     * Check if a board cell with the given coordinates exists
     *
     * @param integer $xCoordinate
     * @param integer $yCoordinate
     * @return boolean
     */
    public function boardCellExists(int $xCoordinate, int $yCoordinate): bool
    {
        $row = isset($this->boardCells[$xCoordinate]) ? $this->boardCells[$xCoordinate] : []; // Check if the row exists.
        if (array_key_exists($yCoordinate, $row)) { // Avoid isset because the cell value could be NULL.
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Store the moves history. 
     * Required for cases of:
     * En passant (https://en.wikipedia.org/wiki/En_passant)
     * History log.
     *
     * @param integer $fromXcoordinate
     * @param integer $fromYcoordinate
     * @param integer $toXcoordinate
     * @param integer $toYcoordinate
     * @param PiecesInterface $Piece
     * @return void
     */
    public function logBoardMove(int $fromXcoordinate, int $fromYcoordinate, int $toXcoordinate, int $toYcoordinate, PiecesInterface $Piece)
    {
        // TO DO: Add event in case of capture and the affected piece.
        throw new \Exception("Need to implement " . __METHOD__);
    }
}