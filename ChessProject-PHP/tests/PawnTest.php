<?php

namespace SolarWinds\Chess;

use SolarWinds\Chess\ChessBoard;
use SolarWinds\Chess\Pieces\Pawn;
use SolarWinds\Chess\Settings\PieceColorEnum;
use SolarWinds\Chess\Settings\ChessBoardSettings;

class PawnTest extends \PHPUnit_Framework_TestCase
{

    /** @var  ChessBoard */
    private $_chessBoard;

    protected function setUp()
    {
        $ChessBoardSettings = new ChessBoardSettings;
        $this->_chessBoard = new ChessBoard($ChessBoardSettings, PieceColorEnum::WHITE());
    }

    /**
     * Test to move 1 and 2 steps forward WITHOUT OBSTACLE pieces on the way.
     * NOTE: Assert the new coordinates.
     *
     * @dataProvider moveToAllowedCellProvider
     */
    public function testMoveToAllowedCell($xCoordinate, $yCoordinate, $newX, $newY, $PieceColorEnum)
    {
        $_testSubject = new Pawn($PieceColorEnum);

        $_testSubject->setXCoordinate($xCoordinate);
        $_testSubject->setYCoordinate($yCoordinate);

        $this->_chessBoard->setPieceToCell($_testSubject);

        $_testSubject->setChessBoard($this->_chessBoard);
        $_testSubject->move($newX, $newY);

        $this->assertEquals($newX, $_testSubject->getXCoordinate());
        $this->assertEquals($newY, $_testSubject->getYCoordinate());
    }

    /**
     * Test to move 1 and 2 steps forward WITH OBSTACLE pieces on the way.
     * NOTE: Assert the old coordinates (The obstacle prevents the movement).
     *
     * @dataProvider moveToAllowedCellProvider
     */
    public function testMoveToAllowedCellWithObstacle($xCoordinate, $yCoordinate, $newX, $newY, $PieceColorEnum)
    {
        $_testSubject = new Pawn($PieceColorEnum);

        // Set an obstacle piece:
        $_testSubject->setXCoordinate($newX);
        $_testSubject->setYCoordinate($newY);
        $this->_chessBoard->setPieceToCell($_testSubject);

        // Set the test piece:
        $_testSubject->setXCoordinate($xCoordinate);
        $_testSubject->setYCoordinate($yCoordinate);
        $this->_chessBoard->setPieceToCell($_testSubject);

        $_testSubject->setChessBoard($this->_chessBoard);
        $_testSubject->move($newX, $newY);

        $this->assertEquals($xCoordinate, $_testSubject->getXCoordinate());
        $this->assertEquals($yCoordinate, $_testSubject->getYCoordinate());
    }

    public function moveToAllowedCellProvider()
    {
        return [
            [0,1,0,2,PieceColorEnum::WHITE()], // White step one field forward.
            [1,1,1,3,PieceColorEnum::WHITE()], // White step two fields forward.
            [0,6,0,5,PieceColorEnum::BLACK()], // Black step one field forward.
            [1,6,1,4,PieceColorEnum::BLACK()], // Black step two fields forward.
        ];
    }

    /**
     * Test to forbiden cells.
     * NOTE: Assert the old coordinates.
     *
     * @dataProvider moveToForbidenCellProvider
     */
    public function testMoveToForbidenCell($xCoordinate, $yCoordinate, $newX, $newY, $PieceColorEnum)
    {
        $_testSubject = new Pawn($PieceColorEnum);

        $_testSubject->setXCoordinate($xCoordinate);
        $_testSubject->setYCoordinate($yCoordinate);

        $this->_chessBoard->setPieceToCell($_testSubject);

        $_testSubject->setChessBoard($this->_chessBoard);
        $_testSubject->move($newX, $newY);

        $this->assertEquals($xCoordinate, $_testSubject->getXCoordinate());
        $this->assertEquals($yCoordinate, $_testSubject->getYCoordinate());
    }

    public function moveToForbidenCellProvider()
    {
        return [
            [0,1,1,5,PieceColorEnum::WHITE()],
            [1,1,1,6,PieceColorEnum::WHITE()],
            [0,6,4,6,PieceColorEnum::BLACK()],
            [1,6,2,5,PieceColorEnum::BLACK()],
        ];
    }

}
