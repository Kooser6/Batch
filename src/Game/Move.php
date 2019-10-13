<?php
declare(strict_types=1);

namespace Phoenix\Game;

/**
 * Adds the ability to make moves on the 4 player chessboard.
 */
class Move
{
    /**
     * Attempt to move a piece.
     *
     * @param $from      The from square.
     * @param $to        The to square.
     * @param $promotion The piece the pawn transforms into.
     * @param $commit    Should we commit the transaction?
     *
     * @return bool Returns true if the move is valid and false if not.
     */
    public static function move(string $from, string $to, string $promotion = 'Q', bool $commit = true): bool
    {
        if (empty(Utils::$saveState)) {
            Utils::startTransaction();
        }
        if (Utils::$moveNumber == 1) {
            $exportData = Game::exportData(\false);
            \array_push(Utils::$boardPositions, [$exportData, 'R']);
        }
        $info = Utils::getSquareInfo($from);
        if ($info['color'] == Utils::$move) {
            $castleMoves = Mover::castleMoves($info['color']);
            $kingMoves   = Mover::kingMoves($info['color']);
            $queenMoves  = Mover::queenMoves($info['color']);
            $bishopMoves = Mover::bishopMoves($info['color']);
            $rookMoves   = Mover::rookMoves($info['color']);
            $knightMoves = Mover::knightMoves($info['color']);
            $pawnMoves   = Mover::pawnMoves($info['color']);
        } else {
            $castleMoves = [];
            $kingMoves   = [];
            $queenMoves  = [];
            $bishopMoves = [];
            $rookMoves   = [];
            $knightMoves = [];
            $pawnMoves   = [];
        }
        $res = false;
        if (State::inDoubleCheck($info['color'])) {
            goto kingMoves;
        }
        if (!empty($pawnMoves) && $info['piece'] == 'P') {
            foreach ($pawnMoves as $fromData => $toData) {
                foreach ($toData as $toLocation) { 
                    if (is_array($toLocation)) {
                        $location_x = $toLocation[0];
                        $enpassant = $toLocation[1];
                    } else {
                        $location_x = $toLocation;
                        $enpassant = '-';
                    }
                    if ($from == $fromData && $location_x == $to) {
                        $res = self::alterState($from, $location_x, 'pawns', $info['color'], $promotion, $enpassant);
                        goto commit;
                    }
                }
            }
        }
        if (!empty($rookMoves) && $info['piece'] == 'R') {
            foreach ($rookMoves as $fromData => $toData) {
                foreach ($toData as $toLocation) { 
                    if ($from == $fromData && $toLocation == $to) {
                        $res = self::alterState($from, $toLocation, 'rooks', $info['color']);
                        goto commit;
                    }
                }
            }
        }
        if (!empty($bishopMoves) && $info['piece'] == 'B') {
            foreach ($bishopMoves as $fromData => $toData) {
                foreach ($toData as $toLocation) { 
                    if ($from == $fromData && $toLocation == $to) {
                        $res = self::alterState($from, $toLocation, 'bishops', $info['color']);
                        goto commit;
                    }
                }
            }
        }
        if (!empty($knightMoves) && $info['piece'] == 'N') {
            foreach ($knightMoves as $fromData => $toData) {
                foreach ($toData as $toLocation) { 
                    if ($from == $fromData && $toLocation == $to) {
                        $res = self::alterState($from, $toLocation, 'knights', $info['color']);
                        goto commit;
                    }
                }
            }
        }
        if (!empty($queenMoves) && $info['piece'] == 'Q') {
            foreach ($queenMoves as $fromData => $toData) {
                foreach ($toData as $toLocation) { 
                    if ($from == $fromData && $toLocation == $to) {
                        $res = self::alterState($from, $toLocation, 'queens', $info['color']);
                        goto commit;
                    }
                }
            }
        }
        if (!State::inCheck($info['color'])) {
            if (!empty($castleMoves) && $info['piece'] == 'K') {
                foreach ($castleMoves as $fromData => $toData) {
                    foreach ($toData as $toLocation) { 
                        if ($from == $fromData && $toLocation == $to) {
                            $res = self::alterState($from, $toLocation, 'castles', $info['color']);
                            goto commit;
                        }
                    }
                }
            }
        }
        kingMoves:
        if (!empty($kingMoves) && $info['piece'] == 'K') {
            foreach ($kingMoves as $fromData => $toData) {
                foreach ($toData as $toLocation) { 
                    if ($from == $fromData && $toLocation == $to) {
                        $res = self::alterState($from, $toLocation, 'kings', $info['color']);
                        goto commit;
                    }
                }
            }
        }
        commit:
        if (Utils::$saveState['board'] == Game::$board) {
            $res = false;
        }
        if ($commit) {
            Utils::commitTransaction();
        }
        return (bool) $res;
    }

    /**
     * Alter the game state.
     *
     * @param string $from      The from location.
     * @param string $to        The to location.
     * @param string $pieceType The type of piece that we are altering.
     * @param string $color     The players color.
     * @param string $promotion The piece promotion code.
     * @param string $enpassant The new enpassant square (pawns).
     *
     * @return bool Returns true if the board alter was a success and false if otherwise.
     */
    private static function alterState(string $from, string $to, string $pieceType, string $color, string $promotion = 'Q', string $enpassant = '-'): bool
    {
        $nextColor = 'R';
        if ($color == 'R') {
            $nextColor = 'B';
        }
        if ($color == 'B') {
            $nextColor = 'Y';
        }
        if ($color == 'Y') {
            $nextColor = 'G';
        }
        if ($color == 'G') {
            $nextColor = 'R';
        }
        if ($color == 'R' || $color == 'Y') {
            $oppositeColors = [
                'B',
                'G',
            ];
        } else {
            $oppositeColors = [
                'R',
                'Y',
            ];
        }
        $board_x = Game::$board;
        $pieces_x = Utils::$pieces;
        $halfMoves_x = Utils::$halfMoves;
        $castle_x = Utils::$castle;
        switch ($pieceType) {
            case 'pawns':
                $x1 = Utils::translateToNumber($from[0]);
                $x2 = Utils::translateToNumber($to[0]);
                $y1 = \intval(\substr($from, 1));
                $y2 = \intval(\substr($to, 1));
                if ($color == 'R' || $color == 'Y') {
                    if ($x1 == $x2 && Utils::isEmptySquare($to)) {
                        $pieceCode = Game::$board[$from];
                        Game::$board[$from] = $from;
                        Utils::$pieces[$pieceCode][0] = $to;
                        Game::$board[$to] = $pieceCode;
                    } elseif (!Utils::isEmptySquare($to)) {
                        $pieceCode1 = Game::$board[$from];
                        Game::$board[$from] = $from;
                        $pieceCode2 = Game::$board[$to];
                        Game::$board[$to] = $pieceCode1;
                        Utils::$pieces[$pieceCode2] = \false;
                        Utils::$pieces[$pieceCode1][0] = $to;
                    } else {
                        $pieceCode = Game::$board[$from];
                        Game::$board[$from] = $from;
                        Utils::$pieces[$pieceCode][0] = $to;
                        Game::$board[$to] = $pieceCode;
                    }
                } elseif ($color == 'B' || $color == 'G') {
                    if ($y1 == $y2 && Utils::isEmptySquare($to)) {
                        $pieceCode = Game::$board[$from];
                        Game::$board[$from] = $from;
                        Utils::$pieces[$pieceCode][0] = $to;
                        Game::$board[$to] = $pieceCode;
                    } elseif (!Utils::isEmptySquare($to)) {
                        $pieceCode1 = Game::$board[$from];
                        Game::$board[$from] = $from;
                        $pieceCode2 = Game::$board[$to];
                        Game::$board[$to] = $pieceCode1;
                        Utils::$pieces[$pieceCode2] = \false;
                        Utils::$pieces[$pieceCode1][0] = $to;
                    } else {
                        $pieceCode = Game::$board[$from];
                        Game::$board[$from] = $from;
                        Utils::$pieces[$pieceCode][0] = $to;
                        Game::$board[$to] = $pieceCode;
                    }
                } else {
                    //
                }
                if (Utils::isPromotionSquare($to, $color)) {
                    $toCode = Game::$board[$to];
                    Utils::$pieces[$toCode][1] = $promotion;
                }
                Utils::$halfMoves = 0;
            break;
            case 'rooks':
                if (!Utils::isEmptySquare($to)) {
                    $pieceCode1 = Game::$board[$from];
                    Game::$board[$from] = $from;
                    $pieceCode2 = Game::$board[$to];
                    Game::$board[$to] = $pieceCode1;
                    Utils::$pieces[$pieceCode2] = \false;
                    Utils::$pieces[$pieceCode1] = $to;
                    Utils::$halfMoves = 0;
                    if (\in_array($from, Mover::$ksRookSquares)) {
                        Utils::$castle[$color]['KS'] = \false;
                    } elseif (\in_array($from, Mover::$qsRookSquares)) {
                        Utils::$castle[$color]['QS'] = \false;
                    } else {
                        //
                    }
                } else {
                    $pieceCode = Game::$board[$from];
                    Game::$board[$from] = $from;
                    Utils::$pieces[$pieceCode] = $to;
                    Game::$board[$to] = $pieceCode;
                    Utils::$halfMoves++;
                    if (\in_array($from, Mover::$ksRookSquares)) {
                        Utils::$castle[$color]['KS'] = \false;
                    } elseif (\in_array($from, Mover::$qsRookSquares)) {
                        Utils::$castle[$color]['QS'] = \false;
                    } else {
                        //
                    }
                }
            break;
            case 'bishops':
                if (!Utils::isEmptySquare($to)) {
                    $pieceCode1 = Game::$board[$from];
                    Game::$board[$from] = $from;
                    $pieceCode2 = Game::$board[$to];
                    Game::$board[$to] = $pieceCode1;
                    Utils::$pieces[$pieceCode2] = \false;
                    Utils::$pieces[$pieceCode1] = $to;
                    Utils::$halfMoves = 0;
                } else {
                    $pieceCode = Game::$board[$from];
                    Game::$board[$from] = $from;
                    Utils::$pieces[$pieceCode] = $to;
                    Game::$board[$to] = $pieceCode;
                    Utils::$halfMoves++;
                }
            break;
            case 'knights':
                if (!Utils::isEmptySquare($to)) {
                    $pieceCode1 = Game::$board[$from];
                    Game::$board[$from] = $from;
                    $pieceCode2 = Game::$board[$to];
                    Game::$board[$to] = $pieceCode1;
                    Utils::$pieces[$pieceCode2] = \false;
                    Utils::$pieces[$pieceCode1] = $to;
                    Utils::$halfMoves = 0;
                } else {
                    $pieceCode = Game::$board[$from];
                    Game::$board[$from] = $from;
                    Utils::$pieces[$pieceCode] = $to;
                    Game::$board[$to] = $pieceCode;
                    Utils::$halfMoves++;
                }
            break;
            case 'queens':
                if (!Utils::isEmptySquare($to)) {
                    $pieceCode1 = Game::$board[$from];
                    Game::$board[$from] = $from;
                    $pieceCode2 = Game::$board[$to];
                    Game::$board[$to] = $pieceCode1;
                    Utils::$pieces[$pieceCode2] = \false;
                    Utils::$pieces[$pieceCode1] = $to;
                    Utils::$halfMoves = 0;
                } else {
                    $pieceCode = Game::$board[$from];
                    Game::$board[$from] = $from;
                    Utils::$pieces[$pieceCode] = $to;
                    Game::$board[$to] = $pieceCode;
                    Utils::$halfMoves++;
                }
            break;
            case 'castles':
                $pieceCode = Game::$board[$from];
                Game::$board[$from] = $from;
                Utils::$pieces[$pieceCode] = $to;
                Game::$board[$to] = $pieceCode;
                if (\in_array($to, Mover::$ksKingSquares)) {
                    $rookSquare = Mover::$ksRookSquare[$color];
                    $rookTo = Mover::$ksRookTo[$color];
                    $pieceCode = Game::$board[$rookSquare];
                    Game::$board[$rookSquare] = $rookSquare;
                    Utils::$pieces[$pieceCode] = $rookTo;
                    Game::$board[$rookTo] = $pieceCode;
                    Utils::$castle[$color]['KS'] = \false;
                } elseif (\in_array($to, Mover::$qsKingSquares)) {
                    $rookSquare = Mover::$qsRookSquare[$color];
                    $rookTo = Mover::$qsRookTo[$color];
                    $pieceCode = Game::$board[$rookSquare];
                    Game::$board[$rookSquare] = $rookSquare;
                    Utils::$pieces[$pieceCode] = $rookTo;
                    Game::$board[$rookTo] = $pieceCode;
                    Utils::$castle[$color]['QS'] = \false;
                } else {
                    //
                }
                Utils::$halfMoves++;
            break;
            case 'kings':
                if (!Utils::isEmptySquare($to)) {
                    $pieceCode1 = Game::$board[$from];
                    Game::$board[$from] = $from;
                    $pieceCode2 = Game::$board[$to];
                    Game::$board[$to] = $pieceCode1;
                    Utils::$pieces[$pieceCode2] = \false;
                    Utils::$pieces[$pieceCode1] = $to;
                    Utils::$halfMoves = 0;
                } else {
                    $pieceCode = Game::$board[$from];
                    Game::$board[$from] = $from;
                    Utils::$pieces[$pieceCode] = $to;
                    Game::$board[$to] = $pieceCode;
                    Utils::$halfMoves++;
                }
            break;
            default:
                //
            break;
        }
        if (State::inCheck($color)) {
            Game::$board = $board_x;
            Utils::$pieces = $pieces_x;
            Utils::$halfMoves = $halfMoves_x;
            Utils::$castle = $castle_x;
            return \false;
        } else {
            $exportData = Game::exportData(\false);
            \array_push(Utils::$boardPositions, [$exportData, $nextColor]);
            Utils::$moveNumber++;
            if ($nextColor == 'R') {
                Utils::$enpassantR = $enpassant;
            } elseif ($nextColor == 'B') {
                Utils::$enpassantB = $enpassant;
            } elseif ($nextColor == 'Y') {
                Utils::$enpassantY = $enpassant;
            } else {
                Utils::$enpassantG = $enpassant;
            }
            Utils::$move = $nextColor;
            return \true;
        }
    }
}
