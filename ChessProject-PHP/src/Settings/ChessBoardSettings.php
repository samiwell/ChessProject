<?php

namespace SolarWinds\Chess\Settings;

class ChessBoardSettings implements ChessBoardSettingsInterface 
{

    const MAX_BOARD_WIDTH = 8;
    const MAX_BOARD_HEIGHT = 8;

    public static function getMaxBoardWidth()
    {
        return self::MAX_BOARD_WIDTH;
    }

    public static function getMaxBoardHeight()
    {
        return self::MAX_BOARD_HEIGHT;
    }
    
}