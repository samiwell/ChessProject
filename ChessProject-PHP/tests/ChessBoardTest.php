<?php

namespace SolarWinds\Chess;

use SolarWinds\Chess\ChessBoard;
use SolarWinds\Chess\Settings\PieceColorEnum;
use SolarWinds\Chess\Settings\ChessBoardSettings;

class ChessBoardTest extends \PHPUnit_Framework_TestCase
{

    /** @var  ChessBoard */
    private $_testSubject;

    public function setUp()
    {
        $ChessBoardSettings = new ChessBoardSettings;
        $this->_testSubject = new ChessBoard($ChessBoardSettings, PieceColorEnum::WHITE());
    }

    public function testHas_MaxBoardWidth_of_8()
    {
        $this->assertEquals(8, ChessBoardSettings::getMaxBoardWidth());
    }

    public function testHas_MaxBoardHeight_of_8()
    {
        $this->assertEquals(8, ChessBoardSettings::getMaxBoardHeight());
    }

    /**
     * Test boardCellExists()
     *
     * @dataProvider boardCellExistsProvider
     */
    public function testBoardCellExists($xCoordinate, $yCoordinate, $exists)
    {
        $isValidPosition = $this->_testSubject->boardCellExists($xCoordinate, $yCoordinate);
        $this->assertEquals($isValidPosition, $exists);
    }

    public function boardCellExistsProvider()
    {
        return [
            [0, 0, true],
            [5, 5, true],
            [11, 5, false],
            [0, 9, false],
            [11, 0, false],
            [5, -1, false],
        ];
    }

    /**
     * Test getCellNameByCoordinates
     *
     * @dataProvider getCellNameByCoordinatesProvider
     */
    public function testGetCellNameByCoordinates($xCoordinate, $yCoordinate, $cellName)
    {
        $this->assertEquals($cellName, $this->_testSubject->getCellNameByCoordinates($xCoordinate, $yCoordinate));
    }

    public function getCellNameByCoordinatesProvider()
    {
        return [
            [0,0,'A1'],
            [0,1,'A2'],
            [3,6,'D7'],
        ];
    }

}
