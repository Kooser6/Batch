<?php
declare(strict_types=1);

namespace Phoenix\Game;

/**
 * Used to list the current state of the 4 player chess game.
 */
class State
{
    /**
     * Check to see if the current color is in check.
     *
     * @param $color The color to check.
     *
     * @return mixed Returns false if not in check or an array of the attacking squares
     */
    public static function inCheck(string $color)
    {
        $ret = [];
        $pieces = Utils::$pieces;
        $king = $pieces[$color . 'K'];
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
        foreach ($pieces as $name => $location) {
            if (\in_array(substr($name, 0, 1), $oppositeColors)) {
                if (\is_array($location)) {
                    $location = $location[0];
                }
                if ($location) {
                    if (Threat::IsThreat($location, $king)) {
                        $ret[] = $location;
                    }
                }
            } 
        }
        if (empty($ret)) {
            return \false;
        } elseif (count($ret) == 1) {
            return $ret[0];
        } else {
            return $ret;
        }
    }

    /**
     * Check to see if a color is in double check.
     *
     * @param string $color The color to check.
     *
     * @return bool Returns true if the king is being double attacked otherwise false.
     */
    public static function inDoubleCheck(string $color): bool
    {
        $res = self::inCheck($color);
        if (!$res || !\is_array($res)) {
            return \false;
        }
        return \true;
    }

    /**
     * Check to see if the current color is in a stalemate.
     *
     * @param $color The color to check.
     *
     * @return bool Returns true if the player is in stalemate and false if not.
     */
    public static function inStalemate(string $color): bool
    {
        $res = self::inCheck($color);
        if (!$res) {
            $pmoves = Mover::pawnMoves($color);
            $kmoves = Mover::kingMoves($color);
            $nmoves = Mover::knightMoves($color);
            $qmoves = Mover::queenMoves($color);
            $bmoves = Mover::bishopMoves($color);
            $rmoves = Mover::rookMoves($color);
            if (!empty($pmoves) || !empty($kmoves) || !empty($nmoves) || !empty($qmoves) || !empty($bmoves) || !empty($rmoves)) {
                return \false;
            }
            return \true;
        }
        return \false;
    }

    /**
     * Check to see if the current color is in checkmate.
     *
     * @param $color The color to check.
     *
     * @return bool Returns false if we are not in checkmate else return true.
     */
    public static function inCheckmate(string $color): bool
    {
        $res = self::inCheck($color);
        if ($res) {
            $pmoves = Mover::pawnMoves($color);
            $kmoves = Mover::kingMoves($color);
            $nmoves = Mover::knightMoves($color);
            $qmoves = Mover::queenMoves($color);
            $bmoves = Mover::bishopMoves($color);
            $rmoves = Mover::rookMoves($color);
            $allMoves = [
                $pmoves,
                $kmoves,
                $nmoves,
                $qmoves,
                $bmoves,
                $rmoves,
            ];
            foreach ($allMoves as $sections) {
                foreach ($sections as $from => $toData) {
                    foreach ($toData as $location_a) {
                        if (is_array($location_a)) {
                            $location_a = $location_a[0];
                        }
                        Utils::startTransaction();
                        Move::move($from, $location_a, 'Q', false);
                        if (!self::inCheck($color)) {
                            Utils::rollbackTransaction();
                            Utils::commitTransaction();
                            return \false;
                        }
                        Utils::rollbackTransaction();
                        Utils::commitTransaction();
                    }
                }
            }
        } else {
            return \false;
        }
        return \true;
    }

    /**
     * Check to see if we are in halfmoves.
     *
     * @return bool Returns false if we are not in checkmate else return true.
     */
    public static function inHalfmoves(): bool
    {
        if (Utils::$halfMoves > 49) {
            return \true;
        }
        return \false;
    }

    /**
     * Check to see if we are in 3 fold rep.
     *
     * @return bool Returns false if we are not in 3 fold rep else return true.
     */
    public static function in3FoldRep(): bool
    {
        foreach (Utils::$boardPositions as $position) {
            $keys = \array_keys(Utils::$boardPositions, $position);
            if (\count($keys) > 2) {
                return \true;
            }
        }
        return \false;
    }

    /**
     * Check to see if to many moves were made.
     *
     * @return bool Returns true if the max moves were reachedand false if not.
     */
    public static function maxMoves(): bool
    {
        if (Utils::$moveNumber > 800) {
            return \true;
        }
        return \false;
    }

    /**
     * Get the result of the currently being played game.
     *
     * @return string The game result.
     */
    public static function getResult(): string
    {
        if (!self::gameOver()) {
            return '*';
        } elseif (self::inCheckmate('R') || self::inCheckmate('Y')) {
            return '-';
        } elseif (self::inCheckmate('B') || self::inCheckmate('G')) {
            return '+';
        } else {
            return '1/2';
        }
    }

    /**
     * Check to see if the game is over.
     *
     * @return bool Returns false if we are not done playing else return true.
     */
    public static function gameOver(): bool
    {
        return self::inCheckmate(Utils::$move) || self::inStalemate(Utils::$move) || self::inHalfmoves() || self::in3FoldRep() || self::maxMoves();
    }
}
