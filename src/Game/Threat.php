<?php
declare(strict_types=1);

namespace Phoenix\Game;

/**
 * Used to determine threats on a 4 player chess board.
 */
class Threat
{
    /**
     * Determine if we should worry about the `$from` square.
     *
     * @param string $from The from square.
     * @param string $to   The to square.
     *
     * @return bool Returns true if the `$to` square is under fire by the `$from` square.
     */
    public static function isThreat(string $from, string $to): bool
    {
        $info = Utils::getSquareInfo($from);
        switch ($info['piece']) {
            case 'P':
                return self::isPawnThreat($from, $to);
            break;
            case 'K':
                return self::isKingThreat($from, $to);
            break;
            case 'Q':
                return self::isQueenThreat($from, $to);
            break;
            case 'R':
                return self::isRookThreat($from, $to);
            break;
            case 'B':
                return self::isBishopThreat($from, $to);
            break;
            case 'N':
                return self::isKnightThreat($from, $to);
            break;
            default:
                //    
            break;
        }
        return false;
    }

    /**
     * Can the pawn touch us?
     *
     * @param string $from The from square.
     * @param string $to   The to square.
     *
     * @return bool Returns true if the `$to` square is under fire by a pawn.
     */
    public static function isPawnThreat(string $from, string $to): bool
    {
        $info = Utils::getSquareInfo($from);
        $color = $info['color'];
        $x1 = Utils::translateToNumber($from[0]);
        $x2 = Utils::translateToNumber($to[0]);
        $y1 = \intval(\substr($from, 1));
        $y2 = \intval(\substr($to, 1));
        if ($color == 'R') {
            $y = $y1 + 1;
            $x_1 = $x1 + 1;
            $x_2 = $x1 - 1;
            if ($x_1 == $x2 && $y == $y2 || $x_2 == $x2 && $y == $y2) {
                return \true;
            }
            return false;
        } elseif ($color == 'B') {
            $x = $x1 + 1;
            $y_1 = $y1 + 1;
            $y_2 = $y1 - 1;
            if ($x == $x2 && $y_1 == $y2 || $x == $x2 && $y_2 == $y2) {
                return \true;
            }
            return \false;
            
        } elseif ($color == 'Y') {
            $y = $y1 - 1;
            $x_1 = $x1 + 1;
            $x_2 = $x1 - 1;
            if ($x_1 == $x2 && $y == $y2 || $x_2 == $x2 && $y == $y2) {
                return \true;
            }
            return \false;
        } elseif ($color == 'G') {
            $x = $x1 - 1;
            $y_1 = $y1 + 1;
            $y_2 = $y1 - 1;
            if ($x == $x2 && $y_1 == $y2 || $x == $x2 && $y_2 == $y2) {
                return \true;
            }
            return \false;
        } else {
            return \false;
        }
    }

    /**
     * Can the king touch us?
     *
     * @param string $from The from square.
     * @param string $to   The to square.
     *
     * @return bool Returns true if the `$to` square is under fire by a king.
     */
    public static function isKingThreat(string $from, string $to): bool
    {
        $x1 = \Utils::translateToNumber($from[0]);
        $x2 = \Utils::translateToNumber($to[0]);
        $y1 = \intval(\substr($from, 1));
        $y2 = \intval(\substr($to, 1));
        if ($x1 > $x2) {
            $spaces_1 = $x1 - $x2;
            if ($spaces_1 != 1) {
                return \false;
            }
        }
        if ($x2 > $x1) {
            $spaces_2 = $x2 - $x1;
            if ($spaces_2 != 1) {
                return \false;
            }
        }
        if ($y1 > $y2) {
            $spaces_3 = $y1 - $y2;
            if ($spaces_3 != 1) {
                return \false;
            }
        }
        if ($y2 > $y1) {
            $spaces_4 = $y2 - $y1;
            if ($spaces_4 != 1) {
                return \false;
            }
        }
        return \true;
    }

    /**
     * Can the queen touch us?
     *
     * @param string $from The from square.
     * @param string $to   The to square.
     *
     * @return bool Returns true if the `$to` square is under fire by a queen.
     */
    public static function isQueenThreat(string $from, string $to): bool
    {
        return self::isRookThreat($from, $to) || self::isBishopThreat($from, $to);
    }

    /**
     * Can the rook touch us?
     *
     * @param string $from The from square.
     * @param string $to   The to square.
     *
     * @return bool Returns true if the `$to` square is under fire by a rook.
     */
    public static function isRookThreat(string $from, string $to): bool
    {
        $x1 = Utils::translateToNumber($from[0]);
        $x2 = Utils::translateToNumber($to[0]);
        $y1 = \intval(\substr($from, 1));
        $y2 = \intval(\substr($to, 1));
        if ($x1 == $x2) {
            if ($y1 > $y2) {
                $spaces = $y1 - $y2;
                if ($spaces > 1) {
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1;
                        $y = \strval($y1 - $i);
                        if (!Utils::isEmptySquare(Utils::translateToLetter($x) . $y)) {
                            return \false;
                        }
                        $spaces--;
                        $i++;
                    }
                }
                return \true;
            }
            if ($y2 > $y1) {
                $spaces = $y2 - $y1;
                if ($spaces > 1) {
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1;
                        $y = \strval($y1 + $i);
                        if (!Utils::isEmptySquare(Utils::translateToLetter($x) . $y)) {
                            return \false;
                        }
                        $spaces--;
                        $i++;
                    }
                }
                return \true;
            }
        } elseif ($y1 == $y2) {
            if ($x1 > $x2) {
                $spaces = $x1 - $x2;
                if ($spaces > 1) {
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 - $i;
                        $y = \strval($y1);
                        if (!Utils::isEmptySquare(Utils::translateToLetter($x) . $y)) {
                            return \false;
                        }
                        $spaces--;
                        $i++;
                    }
                }
                return \true;
            }
            if ($x2 > $x1) {
                $spaces = $x2 - $x1;
                if ($spaces > 1) {
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 + $i;
                        $y = \strval($y1);
                        if (!Utils::isEmptySquare(Utils::translateToLetter($x) . $y)) {
                            return false;
                        }
                        $spaces--;
                        $i++;
                    }
                }
                return \true;
            }
        }
        return \false;
    }

    /**
     * Can the bishop touch us?
     *
     * @param string $from The from square.
     * @param string $to   The to square.
     *
     * @return bool Returns true if the `$to` square is under fire by a bishop.
     */
    public static function isBishopThreat(string $from, string $to): bool
    {
        $x1 = Utils::translateToNumber($from[0]);
        $x2 = Utils::translateToNumber($to[0]);
        $y1 = \intval(\substr($from, 1));
        $y2 = \intval(\substr($to, 1));
        if ($x1 > $x2) {
            $spaces_x = $x1 - $x2;
            if ($y1 > $y2) {
                $spaces_y = $y1 - $y2;
                if ($spaces_x == $spaces_y) {
                    $spaces = $spaces_x;
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 - $i;
                        $y = \strval($y1 - $i);
                        if (!Utils::isEmptySquare(Utils::translateToLetter($x) . $y)
                            || Utils::isOffBoardSquare(Utils::translateToLetter($x) . $y)) {
                            return \false;
                        }
                        $spaces--;
                        $i++;
                    }
                    return \true;
                }
            }
            if ($y2 > $y1) {
                $spaces_y = $y2 - $y1;
                if ($spaces_x == $spaces_y) {
                    $spaces = $spaces_x;
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 - $i;
                        $y = \strval($y1 + $i);
                        if (!Utils::isEmptySquare(Utils::translateToLetter($x) . $y)
                            || Utils::isOffBoardSquare(Utils::translateToLetter($x) . $y)) {
                            return \false;
                        }
                        $spaces--;
                        $i++;
                    }
                    return \true;
                }
            }
            return \false;
        } elseif ($x2 > $x1) {
            $spaces_x = $x2 - $x1;
            if ($y1 > $y2) {
                $spaces_y = $y1 - $y2;
                if ($spaces_x == $spaces_y) {
                    $spaces = $spaces_x;
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 + $i;
                        $y = \strval($y1 - $i);
                        if (!Utils::isEmptySquare(Utils::translateToLetter($x) . $y)
                            || Utils::isOffBoardSquare(Utils::translateToLetter($x) . $y)) {
                            return \false;
                        }
                        $spaces--;
                        $i++;
                    }
                    return \true;
                }
            }
            if ($y2 > $y1) {
                $spaces_y = $y2 - $y1;
                if ($spaces_x == $spaces_y) {
                    $spaces = $spaces_x;
                    $i = 1; 
                    while ($spaces != 1) {
                        $x = $x1 + $i;
                        $y = \strval($y1 + $i);
                        if (!Utils::isEmptySquare(Utils::translateToLetter($x) . $y)
                            || Utils::isOffBoardSquare(Utils::translateToLetter($x) . $y)) {
                            return \false;
                        }
                        $spaces--;
                        $i++;
                    }
                    return \true;
                }
            }
        }
        return \false;
    }

    /**
     * Can the knight touch us?
     *
     * @param string $from The from square.
     * @param string $to   The to square.
     *
     * @return bool Returns true if the `$to` square is under fire by a knight.
     */
    public static function isKnightThreat(string $from, string $to): bool
    {
        $x1 = Utils::translateToNumber($from[0]);
        $x2 = Utils::translateToNumber($to[0]);
        $y1 = \intval(\substr($from, 1));
        $y2 = \intval(\substr($to, 1));
        $x_1 = $x1 + 2;
        $x_2 = $x1 - 2;
        $y_1 = $y1 + 1;
        $y_2 = $y1 - 1;
        if ($x_1 . $y_1 == $x2 . $y2 ||
            $x_1 . $y_2 == $x2 . $y2 ||
            $x_2 . $y_1 == $x2 . $y2 ||
            $x_2 . $y_2 == $x2 . $y2) {
            return \true;
        }
        $y_1 = $y1 + 2;
        $y_2 = $y1 - 2;
        $x_1 = $x1 + 1;
        $x_2 = $x1 - 1;
        if ($x_1 . $y_1 == $x2 . $y2 ||
            $x_1 . $y_2 == $x2 . $y2 ||
            $x_2 . $y_1 == $x2 . $y2 ||
            $x_2 . $y_2 == $x2 . $y2) {
            return \true;
        }
        return \false;
    }
}
