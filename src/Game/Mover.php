<?php
declare(strict_types=1);

namespace Phoenix\Game;

/**
 * Used to list the possible moves on a 4 player chess board.
 */
class Mover
{
    /**
     * @var array $moveTwoSquares A list of square to allow two space moves for pawns.
     */
    private static $moveTwoSquares = [
        'd2',  'e2',  'f2',  'g2',  'h2',  'i2',  'j2',  'k2',
        'b4',  'b5',  'b6',  'b7',  'b8',  'b9',  'b10', 'b11',
        'd13', 'e13', 'f13', 'g13', 'h13', 'i13', 'j13', 'k13',
        'm4',  'm5',  'm6',  'm7',  'm8',  'm9',  'm10', 'm11',
    ];

    /**
     * @var array $squares A list of squares to to check possible piece moves.
     */
    private static $squares = [
                                 'd14', 'e14', 'f14', 'g14', 'h14', 'i14', 'j14', 'k14',
                                 'd13', 'e13', 'f13', 'g13', 'h13', 'i13', 'j13', 'k13',
                                 'd12', 'e12', 'f12', 'g12', 'h12', 'i12', 'j12', 'k12',
            'a11', 'b11', 'c11', 'd11', 'e11', 'f11', 'g11', 'h11', 'i11', 'j11', 'k11', 'l11', 'm11', 'n11',
            'a10', 'b10', 'c10', 'd10', 'e10', 'f10', 'g10', 'h10', 'i10', 'j10', 'k10', 'l10', 'm10', 'n10',
            'a9',  'b9',  'c9',  'd9',  'e9',  'f9',  'g9',  'h9',  'i9',  'j9',  'k9',  'l9',  'm9',  'n9',
            'a8',  'b8',  'c8',  'd8',  'e8',  'f8',  'g8',  'h8',  'i8',  'j8',  'k8',  'l8',  'm8',  'n8',
            'a7',  'b7',  'c7',  'd7',  'e7',  'f7',  'g7',  'h7',  'i7',  'j7',  'k7',  'l7',  'm7',  'n7',
            'a6',  'b6',  'c6',  'd6',  'e6',  'f6',  'g6',  'h6',  'i6',  'j6',  'k6',  'l6',  'm6',  'n6',
            'a5',  'b5',  'c5',  'd5',  'e5',  'f5',  'g5',  'h5',  'i5',  'j5',  'k5',  'l5',  'm5',  'n5',
            'a4',  'b4',  'c4',  'd4',  'e4',  'f4',  'g4',  'h4',  'i4',  'j4',  'k4',  'l4',  'm4',  'n4',
                                 'd3',  'e3',  'f3',  'g3',  'h3',  'i3',  'j3',  'k3',
                                 'd2',  'e2',  'f2',  'g2',  'h2',  'i2',  'j2',  'k2',
                                 'd1',  'e1',  'f1',  'g1',  'h1',  'i1',  'j1',  'k1',
    ];

    /**
     * @var array $moveTwoSquares A list of castle squares.
     */
    private static $castleCheckSquares = [
        'R' => [
            'QS' => [
                'g1',
                'f1',
            ],
            'KS' => [
                'i1',
                'j1',
            ],
        ],
        'B' => [
            'QS' => [
                'a7',
                'a6',
            ],
            'KS' => [
                'a9',
                'a10',
            ],
        ],
        'Y' => [
            'QS' => [
                'h14',
                'i14',
            ],
            'KS' => [
                'f14',
                'e14',
            ],
        ],
        'G' => [
            'QS' => [
                'n8',
                'n9',
            ],
            'KS' => [
                'n6',
                'n5',
            ],
        ],
    ];

    /**
     * @var array $emptyCastleCheckSquares A list of empty castle squares.
     */
    private static $emptyCastleCheckSquares = [
        'R' => [
            'QS' => [
                'e1',
                'g1',
                'f1',
            ],
            'KS' => [
                'i1',
                'j1',
            ],
        ],
        'B' => [
            'QS' => [
                'a5',
                'a7',
                'a6',
            ],
            'KS' => [
                'a9',
                'a10',
            ],
        ],
        'Y' => [
            'QS' => [
                'j14',
                'h14',
                'i14',
            ],
            'KS' => [
                'f14',
                'e14',
            ],
        ],
        'G' => [
            'QS' => [
                'n10',
                'n8',
                'n9',
            ],
            'KS' => [
                'n6',
                'n5',
            ],
        ],
    ];

    /**
     * @var array $castleLocations The move locations for castling moves.
     */
    private static $castleLocations = [
        'R' => [
            'KS' => 'j1',
            'QS' => 'f1',
        ],
        'B' => [
            'KS' => 'a10',
            'QS' => 'a6',
        ],
        'Y' => [
            'KS' => 'e14',
            'QS' => 'i14',
        ],
        'G' => [
            'KS' => 'n5',
            'QS' => 'n9',
        ],
    ];

    /**
     * @var array $ksRookSquare The rook to squares (kingside).
     */
    public static $ksRookTo = [
        'R' => [
            'i1',
        ],
        'B' => [
            'a9',
        ],
        'Y' => [
            'f14',
        ],
        'G' => [
            'n6',
        ],
    ];

    /**
     * @var array $qsRookSquare The rook to squares (queenside).
     */
    public static $qsRookTo = [
        'R' => [
            'g1',
        ],
        'B' => [
            'a7',
        ],
        'Y' => [
            'h14',
        ],
        'G' => [
            'n8',
        ],
    ];

    /**
     * @var array $ksRookSquare The rook from squares (kingside).
     */
    public static $ksRookSquare = [
        'R' => [
            'k1',
        ],
        'B' => [
            'a11',
        ],
        'Y' => [
            'd14',
        ],
        'G' => [
            'n4',
        ],
    ];

    /**
     * @var array $qsRookSquare The rook from squares (queenside).
     */
    public static $qsRookSquare = [
        'R' => [
            'd1',
        ],
        'B' => [
            'a4',
        ],
        'Y' => [
            'k14',
        ],
        'G' => [
            'n11',
        ],
    ];

    /**
     * @var array $ksKingSquares The to moves for the king when castling (kingside).
     */
    public static $ksKingSquares = [
        'j1',
        'a10',
        'e14',
        'n5',
    ];

    /**
     * @var array $qsKingSquares The to moves for the king when castling (queenside).
     */
    public static $qsKingSquares = [
        'f1',
        'a6',
        'i14',
        'n9',
    ];

    /**
     * @var array $ksRookSquares The to moves for the king when castling (kingside).
     */
    public static $ksRookSquares = [
        'k1',
        'a11',
        'd14',
        'n4',
    ];

    /**
     * @var array $qsRookSquares The to moves for the king when castling (queenside).
     */
    public static $qsRookSquares = [
        'd1',
        'a4',
        'k14',
        'n11',
    ];

    /**
     * List all the possible pawn moves for a color.
     *
     * @param string $color The color to check.
     *
     * @return array An array of avaliable moves.
     */
    public static function pawnMoves(string $color): array
    {
        return self::checkMoves($color, 'P');
    }

    /**
     * List all the possible king moves for a color.
     *
     * @param string $color The color to check.
     *
     * @return array An array of avaliable moves.
     */
    public static function kingMoves(string $color): array
    {
        return self::checkMoves($color, 'K');
    }

    /**
     * List all the possible bishop moves for a color.
     *
     * @param string $color The color to check.
     *
     * @return array An array of avaliable moves.
     */
    public static function bishopMoves(string $color): array
    {
        return self::checkMoves($color, 'B');
    }

    /**
     * List all the possible castle moves for a color.
     *
     * @param string $color The color to check.
     *
     * @return array An array of avaliable moves.
     */
    public static function castleMoves(string $color): array
    {
        $ret = [];
        $king = Utils::$pieces[$color . 'K'];
        $ret[$king] = [];
        $data = [];
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
        if (Utils::$castle[$color]['KS']) {
            foreach (self::$castleCheckSquares[$color]['KS'] as $checkThis) {
                foreach (Utils::$pieces as $name => $location_a) {
                    if (\is_array($location_a)) {
                        $location_a = $location_a[0];
                    }
                    if (!$location_a) {
                        continue;
                    }
                    $info = Utils::getSquareInfo($location_a);
                    if (\in_array($info['color'], $oppositeColors)) {
                        if (Threat::isThreat($location_a, $checkThis)) {
                            goto queenSide;
                        }
                    }
                }
            }
            foreach (self::$emptyCastleCheckSquares[$color]['KS'] as $needsToBeEmpty) {
                if (!Utils::isEmptySquare($needsToBeEmpty)) {
                    goto queenSide;
                }
            }
            \array_push($data, self::$castleLocations[$color]['KS']);
        }
        queenSide:
        if (Utils::$castle[$color]['QS']) {
            foreach (self::$castleCheckSquares[$color]['QS'] as $checkThis) {
                foreach (Utils::$pieces as $name => $location_a) {
                    if (\is_array($location_a)) {
                        $location_a = $location_a[0];
                    }
                    if (!$location_a) {
                        continue;
                    }
                    $info = Utils::getSquareInfo($location_a);
                    if (\in_array($info['color'], $oppositeColors)) {
                        if (Threat::isThreat($location_a, $checkThis)) {
                            goto exitLoops;
                        }
                    }
                }
            }
            foreach (self::$emptyCastleCheckSquares[$color]['QS'] as $needsToBeEmpty) {
                if (!Utils::isEmptySquare($needsToBeEmpty)) {
                    goto exitLoops;
                }
            }
            \array_push($data, self::$castleLocations[$color]['QS']);
        }
        exitLoops:
        if (empty($data)) {
            return [];
        }
        $ret[$king] = $data;
        return $ret;
    }

    /**
     * List all the possible rook moves for a color.
     *
     * @param string $color The color to check.
     *
     * @return array An array of avaliable moves.
     */
    public static function rookMoves(string $color): array
    {
        return self::checkMoves($color, 'R');
    }

    /**
     * List all the possible queen moves for a color.
     *
     * @param string $color The color to check.
     *
     * @return array An array of avaliable moves.
     */
    public static function queenMoves(string $color): array
    {
        return self::checkMoves($color, 'Q');
    }

    /**
     * List all the possible knight moves for a color.
     *
     * @param string $color The color to check.
     *
     * @return array An array of avaliable moves.
     */
    public static function knightMoves(string $color): array
    {
        return self::checkMoves($color, 'N');
    }

    /**
     * List all the possible moves for a color based on user input.
     *
     * @param string $color     The color to check.
     * @param string $pieceType Which piece are we checking.
     *
     * @return array An array of avaliable moves.
     */
    private static function checkMoves(string $color, string $pieceType = 'K'): array
    {
        $ret = [];
        foreach (Utils::$pieces as $name => $location_a) {
            if (\is_array($location_a)) {
                $location_a = $location_a[0];
            }
            if (!$location_a) {
                continue;
            }
            $info = Utils::getSquareInfo($location_a);
            $ret[$location_a] = [];
            if ($info['color'] == $color && $info['piece'] == $pieceType) {
                if ($pieceType == 'P') {
                    $x = Utils::translateToNumber($location_a[0]);
                    $y = \intval(\substr($location_a, 1));
                    switch ($color) {
                        case 'R':
                            if (\in_array($location_a, self::$moveTwoSquares)) {
                                $y_1 = $y + 2;
                            }
                            $y_2 = $y + 1;
                            $x_1 = $x + 1;
                            $x_2 = $x - 1;
                            if (isset($y_1)) {
                                if (Utils::isEmptySquare(Utils::translateToLetter($x) . $y_1)) {
                                    \array_push($ret[$location_a], [Utils::translateToLetter($x) . $y_1, Utils::translateToLetter($x) . $y_2]);
                                }
                            }
                            if (Utils::isEmptySquare(Utils::translateToLetter($x) . $y_2)) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x) . $y_2);
                            }
                            if (!Utils::isEmptySquare(Utils::translateToLetter($x_1) . $y_2)) {
                                $sInfo = Utils::getSquareInfo(Utils::translateToLetter($x_1) . $y_2);
                                if ($sInfo['color'] == 'B' || $sInfo['color'] == 'G') {
                                    \array_push($ret[$location_a], Utils::translateToLetter($x_1) . $y_2);
                                }
                            }
                            if (!Utils::isEmptySquare(Utils::translateToLetter($x_2) . $y_2)) {
                                $sInfo = Utils::getSquareInfo(Utils::translateToLetter($x_2) . $y_2);
                                if ($sInfo['color'] == 'B' || $sInfo['color'] == 'G') {
                                    \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_2);
                                }
                            }
                            if (Utils::translateToLetter($x_1) . $y_2 == Utils::$enpassantB || Utils::translateToLetter($x_1) . $y_2 == Utils::$enpassantG) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_1) . $y_2);
                            }
                            if (Utils::translateToLetter($x_2) . $y_2 == Utils::$enpassantB || Utils::translateToLetter($x_2) . $y_2 == Utils::$enpassantG) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_2);
                            }
                        break;
                        case 'B':
                            if (\in_array($location_a, self::$moveTwoSquares)) {
                                $x_1 = $x + 2;
                            }
                            $x_2 = $x + 1;
                            $y_1 = $y + 1;
                            $y_2 = $y - 1;
                            if (isset($x_1)) {
                                if (Utils::isEmptySquare(Utils::translateToLetter($x_1) . $y)) {
                                    \array_push($ret[$location_a], [Utils::translateToLetter($x_1) . $y, Utils::translateToLetter($x_2) . $y]);
                                }
                            }
                            if (Utils::isEmptySquare(Utils::translateToLetter($x_2) . $y)) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y);
                            }
                            if (!Utils::isEmptySquare(Utils::translateToLetter($x_2) . $y_1)) {
                                $sInfo = Utils::getSquareInfo(Utils::translateToLetter($x_2) . $y_1);
                                if ($sInfo['color'] == 'R' || $sInfo['color'] == 'Y') {
                                    \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_1);
                                }
                            }
                            if (!Utils::isEmptySquare(Utils::translateToLetter($x_2) . $y_2)) {
                                $sInfo = Utils::getSquareInfo(Utils::translateToLetter($x_2) . $y_2);
                                if ($sInfo['color'] == 'R' || $sInfo['color'] == 'Y') {
                                    \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_2);
                                }
                            }
                            if (Utils::translateToLetter($x_2) . $y_1 == Utils::$enpassantR || Utils::translateToLetter($x_2) . $y_1 == Utils::$enpassantY) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_1);
                            }
                            if (Utils::translateToLetter($x_2) . $y_2 == Utils::$enpassantR || Utils::translateToLetter($x_2) . $y_2 == Utils::$enpassantY) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_2);
                            }
                        break;
                        case 'Y':
                            if (\in_array($location_a, self::$moveTwoSquares)) {
                                $y_1 = $y - 2;
                            }
                            $y_2 = $y - 1;
                            $x_1 = $x + 1;
                            $x_2 = $x - 1;
                            if (isset($y_1)) {
                                if (Utils::isEmptySquare(Utils::translateToLetter($x) . $y_1)) {
                                    \array_push($ret[$location_a], [Utils::translateToLetter($x) . $y_1, Utils::translateToLetter($x) . $y_2]);
                                }
                            }
                            if (Utils::isEmptySquare(Utils::translateToLetter($x) . $y_2)) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x) . $y_2);
                            }
                            if (!Utils::isEmptySquare(Utils::translateToLetter($x_1) . $y_2)) {
                                $sInfo = Utils::getSquareInfo(Utils::translateToLetter($x_1) . $y_2);
                                if ($sInfo['color'] == 'B' || $sInfo['color'] == 'G') {
                                    \array_push($ret[$location_a], Utils::translateToLetter($x_1) . $y_2);
                                }
                            }
                            if (!Utils::isEmptySquare(Utils::translateToLetter($x_2) . $y_2)) {
                                $sInfo = Utils::getSquareInfo(Utils::translateToLetter($x_2) . $y_2);
                                if ($sInfo['color'] == 'B' || $sInfo['color'] == 'G') {
                                    \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_2);
                                }
                            }
                            if (Utils::translateToLetter($x_1) . $y_2 == Utils::$enpassantB || Utils::translateToLetter($x_1) . $y_2 == Utils::$enpassantG) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_1) . $y_2);
                            }
                            if (Utils::translateToLetter($x_2) . $y_2 == Utils::$enpassantB || Utils::translateToLetter($x_2) . $y_2 == Utils::$enpassantG) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_2);
                            }
                        break;
                        case 'G':
                            if (\in_array($location_a, self::$moveTwoSquares)) {
                                $x_1 = $x - 2;
                            }
                            $x_2 = $x - 1;
                            $y_1 = $y + 1;
                            $y_2 = $y - 1;
                            if (isset($x_1)) {
                                if (Utils::isEmptySquare(Utils::translateToLetter($x_1) . $y)) {
                                    \array_push($ret[$location_a], [Utils::translateToLetter($x_1) . $y, Utils::translateToLetter($x_2) . $y]);
                                }
                            }
                            if (Utils::isEmptySquare(Utils::translateToLetter($x_2) . $y)) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y);
                            }
                            if (!Utils::isEmptySquare(Utils::translateToLetter($x_2) . $y_1)) {
                                $sInfo = Utils::getSquareInfo(Utils::translateToLetter($x_2) . $y_1);
                                if ($sInfo['color'] == 'R' || $sInfo['color'] == 'Y') {
                                    \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_1);
                                }
                            }
                            if (!Utils::isEmptySquare(Utils::translateToLetter($x_2) . $y_2)) {
                                $sInfo = Utils::getSquareInfo(Utils::translateToLetter($x_2) . $y_2);
                                if ($sInfo['color'] == 'R' || $sInfo['color'] == 'Y') {
                                    \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_2);
                                }
                            }
                            if (Utils::translateToLetter($x_2) . $y_1 == Utils::$enpassantR || Utils::translateToLetter($x_2) . $y_1 == Utils::$enpassantY) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_1);
                            }
                            if (Utils::translateToLetter($x_2) . $y_2 == Utils::$enpassantR || Utils::translateToLetter($x_2) . $y_2 == Utils::$enpassantY) {
                                \array_push($ret[$location_a], Utils::translateToLetter($x_2) . $y_2);
                            }
                        break;
                        default:
                            //
                        break;
                    }
                } else {
                    foreach (self::$squares as $location_b) {
                        if (!Utils::isEmptySquare($location_b)) {
                            if ($color == 'R' || $color == 'Y') {
                                $oppositeColors = ['B', 'G'];
                            } else {
                                $oppositeColors = ['R', 'Y'];
                            }
                            $info = Utils::getSquareInfo($location_b);
                            if (!\in_array($info['color'], $oppositeColors)) {
                                continue;
                            }
                        }
                        if (Threat::isThreat($location_a, $location_b)) {
                            \array_push($ret[$location_a], $location_b);
                        }
                    }
                }
            }
            /** @psalm-suppress RedundantCondition **/
            if (empty($ret[$location_a])) {
                unset($ret[$location_a]);
            }
        }
        return $ret;
    }
}
