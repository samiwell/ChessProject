<?php
namespace SolarWinds\Chess\Pieces;

interface PawnInterface 
{

    /**
     * Mark the `piece` as moved. Required for cases of:
     * En passant (https://en.wikipedia.org/wiki/En_passant) (For `pawns`)
     * Jump (https://en.wikipedia.org/wiki/Pawn_(chess)) (For `pawns`)
     * Castling (https://en.wikipedia.org/wiki/Castling) (For Rooks and Kings)
     * The method is public in order to allow custom game scenarios.
     *
     */
    public function markAsMoved();

    /**
     * Check if the `piece` has been moved. Required for cases of:
     * En passant (https://en.wikipedia.org/wiki/En_passant) (For `pawns`)
     * Jump (https://en.wikipedia.org/wiki/Pawn_(chess)) (For `pawns`)
     * Castling (https://en.wikipedia.org/wiki/Castling) (For `rooks` and Kings)
     *
     * @return boolean
     */
    public function isMoved();

}