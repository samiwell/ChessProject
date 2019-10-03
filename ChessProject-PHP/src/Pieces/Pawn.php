<?php

namespace SolarWinds\Chess\Pieces;

use SolarWinds\Chess\Pieces\PawnInterface;
use SolarWinds\Chess\Pieces\PiecesInterface;
use SolarWinds\Chess\Settings\PieceColorEnum;

class Pawn implements PiecesInterface, PawnInterface
{

    /**
     * Use this constant to multiply the movement direction
     */
    const MULTIPLIER = [
        'WHITE' => 1,
        'BLACK' => -1,
    ];

    /** @var PieceColorEnum */
    private $pieceColorEnum;

    /** @var ChessBoardInterface The current state of the chess board */
    private $chessBoard;

    /** @var int */
    private $xCoordinate;

    /** @var int */
    private $yCoordinate;

    /** @var int */
    private $isMoved = FALSE;

    /**
     * Set the piece color.
     *
     * @param PieceColorEnum $pieceColorEnum
     */
    public function __construct(PieceColorEnum $pieceColorEnum)
    {
        $this->pieceColorEnum = $pieceColorEnum;
    }

    /**
     * Get the chess board current state
     *
     * @return ChessBoardInterface
     */
    public function getChesssBoard(): ChessBoardInterface
    {
        return $this->chessBoard;
    }

    /**
     * Set chess board current state.
     *
     * @param ChessBoardInterface $chessBoard
     */
    public function setChessBoard($chessBoard)
    {
        $this->chessBoard = $chessBoard;
    }

    /** @return int */
    public function getXCoordinate(): int
    {
        return $this->xCoordinate;
    }

    /** @var int */
    public function setXCoordinate($value)
    {
        $this->xCoordinate = $value;
    }

    /** @return int */
    public function getYCoordinate(): int
    {
        return $this->yCoordinate;
    }

    /** @var int */
    public function setYCoordinate($value)
    {
        $this->yCoordinate = $value;
    }

    /**
     * Get the color of the piece.
     *
     * @return PieceColorEnum
     */
    public function getPieceColor(): PieceColorEnum
    {
        return $this->pieceColorEnum;
    }

    /**
     * If the piece has ever been moved.
     *
     * @return boolean
     */
    public function isMoved()
    {
        return $this->isMoved;
    }

    /**
     * Set the piece as moved
     */
    public function markAsMoved()
    {
        $this->isMoved = TRUE;
    }

    /**
     * Get array with all possible future positions that are allowed.
     * NOTE: If there are units in the cells in front of the pawin it will stand still. 
     * (TODO: Split the logic to multiple methods in separate class)
     * (TODO: Capture will be applied later)
     *
     * @return array
     */
    public function getAvailableMoves(): array
    {
        $availableMoves = [];
        $multiplier = self::MULTIPLIER[(string)$this->pieceColorEnum];

        // NOTE: there's no point to check if board cell exists. Reaching the end should have event triger.

        // Check if there's another piece in front of the pawn.
        $defaultForwardStep = $this->yCoordinate + $multiplier;
        $hasPieceInFront = $this->chessBoard->getCellPieceByCoordinates($this->xCoordinate, $defaultForwardStep);

        // Return if there's a piece in front.
        if($hasPieceInFront) {
            return $availableMoves;
        }
        $availableMoves[] = $this->chessBoard->getCellNameByCoordinates($this->xCoordinate, $defaultForwardStep);

        // Return of the pawn was moved.
        if ($this->isMoved) {
            return $availableMoves;
        }

        // If one step is possible and the pawn was not moved `jump` could be considered:
        $jumpStep = $this->yCoordinate + ($multiplier * 2);
        $hasPieceOnJumpField = $this->chessBoard->getCellPieceByCoordinates($this->xCoordinate, $jumpStep);
        if (!$hasPieceOnJumpField) {
            $availableMoves[] = $this->chessBoard->getCellNameByCoordinates($this->xCoordinate, $jumpStep);
        }

        return $availableMoves;
    }

    /**
     * Make a move (if allowed) and update the piece data and the board.
     *
     * @param integer $newX
     * @param integer $newY
     * @return void
     */
    public function move(int $newX, int $newY)
    {
        $availableMoves = $this->getAvailableMoves();
        $requestedPosition = $this->chessBoard->getCellNameByCoordinates($newX, $newY);

        // The move is not allowed:
        if (!in_array($requestedPosition, $availableMoves)) {
            return FALSE;
        }

        // Mark the pawn as moved:
        $this->markAsMoved();

        // Clear the current cell on the board:
        $this->chessBoard->setEmptyCell($this->xCoordinate, $this->yCoordinate);

        // Set the new coordiantes:
        $this->setXCoordinate($newX);
        $this->setYCoordinate($newY);

        // Update the board:
        $this->chessBoard->setPieceToCell($this);
    }

    /**
     * Check if the pawn is protecting the king
     *
     * @return boolean
     */
    public function isProtectingTheKing(): bool
    {
        // TODO...
        return FALSE;
    }

}