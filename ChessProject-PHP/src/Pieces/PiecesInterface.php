<?php
namespace SolarWinds\Chess\Pieces;

interface PiecesInterface {

    /**
     * Set the current status of the `board`.
     *
     * @param ChessBoardInterface $ChessBoard
     */
    public function setChessBoard($ChessBoard);

    /**
     * Return the current state of the `board`.
     *
     * @return ChessBoardInterface
     */
    public function getChesssBoard();

    public function getPieceColor();

    /**
     * Set the X coordinate value.
     *
     * @param integer $value
     * @return integer
     */
    public function setXCoordinate(int $value);

    /**
     * Get X coordinate value.
     *
     * @return integer
     */
    public function getXCoordinate(): int;

    /**
     * Set the Y coordinate.
     *
     * @param int $value
     */
    public function setYCoordinate(int $value);

    /**
     * Get the Y coordinate.
     *
     * @return integer - The Y coordinate value.
     */
    public function getYCoordinate(): int;

    /**
     * Get all available positions for the `piece` to move.
     * NOTE: That includes `capture`.
     * 
     * @return array
     */
    public function getAvailableMoves(): array;

    /**
     * Check if the `piece` protects the `king`.
     *
     * @return boolean
     */
    public function isProtectingTheKing(): bool;

    /**
     * Move a `piece` on the `board`. 
     * NOTE: That includes `capture`.
     *
     * @param integer $newX - The new position on the X coordinate. 
     * @param integer $newY - The new position on the Y coordinate.
     */
    public function move(int $newX, int $newY);

}