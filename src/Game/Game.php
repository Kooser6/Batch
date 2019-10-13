<?php
declare(strict_types=1);

namespace Phoenix\Game;

/**
 * The actual game controller.
 */
class Game
{
    /**
     * @var array $board The starting 4 player chessboard.
     */
    public static $startingBoard = [
                                                        'd14' => 'YR1', 'e14' => 'YN1', 'f14' => 'YB1', 'g14' => 'YK',  'h14' => 'YQ',  'i14' => 'YB2', 'j14' => 'YN2', 'k14' => 'YR2',
                                                        'd13' => 'YP1', 'e13' => 'YP2', 'f13' => 'YP3', 'g13' => 'YP4', 'h13' => 'YP5', 'i13' => 'YP6', 'j13' => 'YP7', 'k13' => 'YP8',
                                                        'd12' => 'd12', 'e12' => 'e12', 'f12' => 'f12', 'g12' => 'g12', 'h12' => 'h12', 'i12' => 'i12', 'j12' => 'j12', 'k12' => 'k12',
        'a11' => 'BR1', 'b11' => 'BP1', 'c11' => 'c11', 'd11' => 'd11', 'e11' => 'e11', 'f11' => 'f11', 'g11' => 'g11', 'h11' => 'h11', 'i11' => 'i11', 'j11' => 'j11', 'k11' => 'k11', 'l11' => 'l11', 'm11' => 'GP8', 'n11' => 'GR2',
        'a10' => 'BN1', 'b10' => 'BP2', 'c10' => 'c10', 'd10' => 'd10', 'e10' => 'e10', 'f10' => 'f10', 'g10' => 'g10', 'h10' => 'h10', 'i10' => 'i10', 'j10' => 'j10', 'k10' => 'k10', 'l10' => 'l10', 'm10' => 'GP7', 'n10' => 'GN2',
        'a9'  => 'BB1', 'b9'  => 'BP3',  'c9' => 'c9',  'd9'  => 'd9',  'e9'  => 'e9',  'f9'  => 'f9',  'g9'  => 'g9',  'h9'  => 'h9',  'i9'  => 'i9',  'j9'  => 'j9',  'k9'  => 'k9',  'l9'  => 'l9',  'm9'  => 'GP6',  'n9' => 'GB2',
        'a8'  => 'BK',  'b8'  => 'BP4',  'c8' => 'c8',  'd8'  => 'd8',  'e8'  => 'e8',  'f8'  => 'f8',  'g8'  => 'g8',  'h8'  => 'h8',  'i8'  => 'i8',  'j8'  => 'j8',  'k8'  => 'k8',  'l8'  => 'l8',  'm8'  => 'GP5',  'n8' => 'GQ',
        'a7'  => 'BQ',  'b7'  => 'BP5',  'c7' => 'c7',  'd7'  => 'd7',  'e7'  => 'e7',  'f7'  => 'f7',  'g7'  => 'g7',  'h7'  => 'h7',  'i7'  => 'i7',  'j7'  => 'j7',  'k7'  => 'k7',  'l7'  => 'l7',  'm7'  => 'GP4',  'n7' => 'GK',
        'a6'  => 'BB2', 'b6'  => 'BP6',  'c6' => 'c6',  'd6'  => 'd6',  'e6'  => 'e6',  'f6'  => 'f6',  'g6'  => 'g6',  'h6'  => 'h6',  'i6'  => 'i6',  'j6'  => 'j6',  'k6'  => 'k6',  'l6'  => 'l6',  'm6'  => 'GP3',  'n6' => 'GB1',
        'a5'  => 'BN2', 'b5'  => 'BP7',  'c5' => 'c5',  'd5'  => 'd5',  'e5'  => 'e5',  'f5'  => 'f5',  'g5'  => 'g5',  'h5'  => 'h5',  'i5'  => 'i5',  'j5'  => 'j5',  'k5'  => 'k5',  'l5'  => 'l5',  'm5'  => 'GP2',  'n5' => 'GN1',
        'a4'  => 'BR2', 'b4'  => 'BP8',  'c4' => 'c4',  'd4'  => 'd4',  'e4'  => 'e4',  'f4'  => 'f4',  'g4'  => 'g4',  'h4'  => 'h4',  'i4'  => 'i4',  'j4'  => 'j4',  'k4'  => 'k4',  'l4'  => 'l4',  'm4'  => 'GP1',  'n4' => 'GR1',
                                                        'd3'  => 'd3',  'e3'  => 'e3',  'f3'  => 'f3',  'g3'  => 'g3',  'h3'  => 'h3',  'i3'  => 'i3',  'j3'  => 'j3',  'k3'  => 'k3',
                                                        'd2'  => 'RP1', 'e2'  => 'RP2', 'f2'  => 'RP3', 'g2'  => 'RP4', 'h2'  => 'RP5', 'i2'  => 'RP6', 'j2'  => 'RP7', 'k2'  => 'RP8',
                                                        'd1'  => 'RR1', 'e1'  => 'RN1', 'f1'  => 'RB1', 'g1'  => 'RQ',  'h1'  => 'RK',  'i1'  => 'RB2', 'j1'  => 'RN2', 'k1'  => 'RR2',
    ];

    /**
     * @var array $board The 4 player chessboard.
     */
    public static $board = [
                                                        'd14' => 'YR1', 'e14' => 'YN1', 'f14' => 'YB1', 'g14' => 'YK',  'h14' => 'YQ',  'i14' => 'YB2', 'j14' => 'YN2', 'k14' => 'YR2',
                                                        'd13' => 'YP1', 'e13' => 'YP2', 'f13' => 'YP3', 'g13' => 'YP4', 'h13' => 'YP5', 'i13' => 'YP6', 'j13' => 'YP7', 'k13' => 'YP8',
                                                        'd12' => 'd12', 'e12' => 'e12', 'f12' => 'f12', 'g12' => 'g12', 'h12' => 'h12', 'i12' => 'i12', 'j12' => 'j12', 'k12' => 'k12',
        'a11' => 'BR1', 'b11' => 'BP1', 'c11' => 'c11', 'd11' => 'd11', 'e11' => 'e11', 'f11' => 'f11', 'g11' => 'g11', 'h11' => 'h11', 'i11' => 'i11', 'j11' => 'j11', 'k11' => 'k11', 'l11' => 'l11', 'm11' => 'GP8', 'n11' => 'GR2',
        'a10' => 'BN1', 'b10' => 'BP2', 'c10' => 'c10', 'd10' => 'd10', 'e10' => 'e10', 'f10' => 'f10', 'g10' => 'g10', 'h10' => 'h10', 'i10' => 'i10', 'j10' => 'j10', 'k10' => 'k10', 'l10' => 'l10', 'm10' => 'GP7', 'n10' => 'GN2',
        'a9'  => 'BB1', 'b9'  => 'BP3',  'c9' => 'c9',  'd9'  => 'd9',  'e9'  => 'e9',  'f9'  => 'f9',  'g9'  => 'g9',  'h9'  => 'h9',  'i9'  => 'i9',  'j9'  => 'j9',  'k9'  => 'k9',  'l9'  => 'l9',  'm9'  => 'GP6',  'n9' => 'GB2',
        'a8'  => 'BK',  'b8'  => 'BP4',  'c8' => 'c8',  'd8'  => 'd8',  'e8'  => 'e8',  'f8'  => 'f8',  'g8'  => 'g8',  'h8'  => 'h8',  'i8'  => 'i8',  'j8'  => 'j8',  'k8'  => 'k8',  'l8'  => 'l8',  'm8'  => 'GP5',  'n8' => 'GQ',
        'a7'  => 'BQ',  'b7'  => 'BP5',  'c7' => 'c7',  'd7'  => 'd7',  'e7'  => 'e7',  'f7'  => 'f7',  'g7'  => 'g7',  'h7'  => 'h7',  'i7'  => 'i7',  'j7'  => 'j7',  'k7'  => 'k7',  'l7'  => 'l7',  'm7'  => 'GP4',  'n7' => 'GK',
        'a6'  => 'BB2', 'b6'  => 'BP6',  'c6' => 'c6',  'd6'  => 'd6',  'e6'  => 'e6',  'f6'  => 'f6',  'g6'  => 'g6',  'h6'  => 'h6',  'i6'  => 'i6',  'j6'  => 'j6',  'k6'  => 'k6',  'l6'  => 'l6',  'm6'  => 'GP3',  'n6' => 'GB1',
        'a5'  => 'BN2', 'b5'  => 'BP7',  'c5' => 'c5',  'd5'  => 'd5',  'e5'  => 'e5',  'f5'  => 'f5',  'g5'  => 'g5',  'h5'  => 'h5',  'i5'  => 'i5',  'j5'  => 'j5',  'k5'  => 'k5',  'l5'  => 'l5',  'm5'  => 'GP2',  'n5' => 'GN1',
        'a4'  => 'BR2', 'b4'  => 'BP8',  'c4' => 'c4',  'd4'  => 'd4',  'e4'  => 'e4',  'f4'  => 'f4',  'g4'  => 'g4',  'h4'  => 'h4',  'i4'  => 'i4',  'j4'  => 'j4',  'k4'  => 'k4',  'l4'  => 'l4',  'm4'  => 'GP1',  'n4' => 'GR1',
                                                        'd3'  => 'd3',  'e3'  => 'e3',  'f3'  => 'f3',  'g3'  => 'g3',  'h3'  => 'h3',  'i3'  => 'i3',  'j3'  => 'j3',  'k3'  => 'k3',
                                                        'd2'  => 'RP1', 'e2'  => 'RP2', 'f2'  => 'RP3', 'g2'  => 'RP4', 'h2'  => 'RP5', 'i2'  => 'RP6', 'j2'  => 'RP7', 'k2'  => 'RP8',
                                                        'd1'  => 'RR1', 'e1'  => 'RN1', 'f1'  => 'RB1', 'g1'  => 'RQ',  'h1'  => 'RK',  'i1'  => 'RB2', 'j1'  => 'RN2', 'k1'  => 'RR2',
    ];

    /**
     * Reset the 4 player chess board.
     *
     * @return void Returns nothing.
     */
    public static function resetBoard(): void
    {
        self::$board = self::$startingBoard;
        Utils::$castle = [
            'R' => [
                'QS' => true,
                'KS' => true,
            ],
            'B' => [
                'QS' => true,
                'KS' => true,
            ],
            'Y' => [
                'QS' => true,
                'KS' => true,
            ],
            'G' => [
                'QS' => true,
                'KS' => true,
            ],
        ];
        Utils::$move = 'R';
        Utils::$moveNumber = 1;
        Utils::$enpassantR = '-';
        Utils::$enpassantB = '-';
        Utils::$enpassantY = '-';
        Utils::$enpassantG = '-';
        Utils::$pieces = [
            'RR1' => 'd1',
            'RN1' => 'e1',
            'RB1' => 'f1',
            'RQ'  => 'g1',
            'RK'  => 'h1',
            'RB2' => 'i1',
            'RN2' => 'j1',
            'RR2' => 'k1',
            'RP1' => ['d2', 'P'],
            'RP2' => ['e2', 'P'],
            'RP3' => ['f2', 'P'],
            'RP4' => ['g2', 'P'],
            'RP5' => ['h2', 'P'],
            'RP6' => ['i2', 'P'],
            'RP7' => ['j2', 'P'],
            'RP8' => ['k2', 'P'],
            'BR1' => 'a11',
            'BN1' => 'a10',
            'BB1' => 'a9',
            'BQ'  => 'a7',
            'BK'  => 'a8',
            'BB2' => 'a6',
            'BN2' => 'a5',
            'BR2' => 'a4',
            'BP1' => ['b11', 'P'],
            'BP2' => ['b10', 'P'],
            'BP3' => ['b9',  'P'],
            'BP4' => ['b8',  'P'],
            'BP5' => ['b7',  'P'],
            'BP6' => ['b6',  'P'],
            'BP7' => ['b5',  'P'],
            'BP8' => ['b4',  'P'],
            'YR1' => 'd14',
            'YN1' => 'e14',
            'YB1' => 'f14',
            'YQ'  => 'h14',
            'YK'  => 'g14',
            'YB2' => 'i14',
            'YN2' => 'j14',
            'YR2' => 'k14',
            'YP1' => ['d13', 'P'],
            'YP2' => ['e13', 'P'],
            'YP3' => ['f13', 'P'],
            'YP4' => ['g13', 'P'],
            'YP5' => ['h13', 'P'],
            'YP6' => ['i13', 'P'],
            'YP7' => ['j13', 'P'],
            'YP8' => ['k13', 'P'],
            'GR1' => 'n4',
            'GN1' => 'n5',
            'GB1' => 'n6',
            'GQ'  => 'n8',
            'GK'  => 'n7',
            'GB2' => 'n9',
            'GN2' => 'n10',
            'GR2' => 'n11',
            'GP1' => ['m4',  'P'],
            'GP2' => ['m5',  'P'],
            'GP3' => ['m6',  'P'],
            'GP4' => ['m7',  'P'],
            'GP5' => ['m8',  'P'],
            'GP6' => ['m9',  'P'],
            'GP7' => ['m10', 'P'],
            'GP8' => ['m11', 'P'],
        ];
        Utils::$halfMoves = 0;
        Utils::$boardPositions = [];
        Utils::$saveState = [];
    }

    /**
     * Export the game information.
     *
     * @param bool $jsonEncode Should we json encode the data.
     *
     * @return mixed Returns the exported data.
     */
    public static function exportData(bool $jsonEncode = false)
    {
        $data = [
            'board'      => self::$board,
            'halfMoves'  => Utils::$halfMoves,
            'positions'  => Utils::$boardPositions,
            'pieces'     => Utils::$pieces,
            'enpassantR' => Utils::$enpassantR,
            'enpassantB' => Utils::$enpassantB,
            'enpassantY' => Utils::$enpassantY,
            'enpassantG' => Utils::$enpassantG,
            'castle'     => Utils::$castle,
            'move'       => Utils::$move,
            'moveNum'    => Utils::$moveNumber,
        ];
        if ($jsonEncode) {
            return json_encode($data);
        }
        return $data;
    }

    /**
     * Import the game information.
     *
     * @param mixed $data The game information.
     *
     * @return void Returns nothing.
     */
    public static function importData($data): void
    {
        if (is_string($data)) {
            $data = json_decode($data);
        }
        Utils::$halfMoves      = $data['halfMoves'];
        Utils::$boardPositions = $data['positions'];
        Utils::$pieces         = $data['pieces'];
        Utils::$enpassantR     = $data['enpassantR'];
        Utils::$enpassantB     = $data['enpassantB'];
        Utils::$enpassantY     = $data['enpassantY'];
        Utils::$enpassantG     = $data['enpassantG'];
        Utils::$castle         = $data['castle'];
        Utils::$move           = $data['move'];
        Utils::$moveNumber     = $data['moveNum'];
        self::$board           = $data['board'];
    }
}
