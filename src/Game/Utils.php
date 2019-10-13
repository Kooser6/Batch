<?php
declare(strict_types=1);

namespace Phoenix\Game;

/**
 * Just a bunch of miscellaneous stuff.
 */
class Utils
{
    /**
     * @var array Castling states.
     */
    public static $castle = [
        'R' => [
            'QS' => \true,
            'KS' => \true,
        ],
        'B' => [
            'QS' => \true,
            'KS' => \true,
        ],
        'Y' => [
            'QS' => \true,
            'KS' => \true,
        ],
        'G' => [
            'QS' => \true,
            'KS' => \true,
        ],
    ];

    /**
     * @var array $translateToNumber Translate a letter to a number.
     */
    private static $translateToNumber = [
        'a' => 1,
        'b' => 2,
        'c' => 3,
        'd' => 4,
        'e' => 5,
        'f' => 6,
        'g' => 7,
        'h' => 8,
        'i' => 9,
        'j' => 10,
        'k' => 11,
        'l' => 12,
        'm' => 13,
        'n' => 14,
    ];

    /**
     * @var array $promotionSquares The promotion squares.
     */
    public static $promotionSquares = [
        'R' => [
            'a11',
            'b11',
            'c11',
            'd11',
            'e11',
            'f11',
            'g11',
            'h11',
            'i11',
            'j11',
            'k11',
            'l11',
            'm11',
            'n11',
        ],
        'B' => [
            'k1',
            'k2',
            'k3',
            'k4',
            'k5',
            'k6',
            'k7',
            'k8',
            'k9',
            'k10',
            'k11',
            'k12',
            'k13',
            'k14',
        ],
        'Y' => [
            'a4',
            'b4',
            'c4',
            'd4',
            'e4',
            'f4',
            'h4',
            'i4',
            'j4',
            'k4',
            'l4',
            'm4',
            'n4',            
        ],
        'G' => [
            'd1',
            'd2',
            'd3',
            'd4',
            'd5',
            'd6',
            'd7',
            'd8',
            'd9',
            'd10',
            'd11',
            'd12',
            'd13',
            'd14',
        ],
    ];

    /**
     * @var array $translateToLetter Translate a number to a letter.
     */
    private static $translateToLetter = [
        1  => 'a',
        2  => 'b',
        3  => 'c',
        4  => 'd',
        5  => 'e',
        6  => 'f',
        7  => 'g',
        8  => 'h',
        9  => 'i',
        10 => 'j',
        11 => 'k',
        12 => 'l',
        13 => 'm',
        14 => 'n',
    ];

    /**
     * @var array $pieces Used to keep track of the pieces.
     */
    public static $pieces = [
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

    /**
     * @var string $move The current move turn.
     */
    public static $move = 'R';

    /**
     * @var array $move All the board positions in the game.
     */
    public static $boardPositions = [];
    
    /**
     * @var int $halfMoves The current half moves.
     */
    public static $halfMoves = 0;

    /**
     * @var array $saveState The current save state.
     */
    public static $saveState = [];

    /**
     * @var string $enpassantR The enpassant square for red.
     */
    public static $enpassantR = '-';

    /**
     * @var string $enpassantB The enpassant square for blue.
     */
    public static $enpassantB = '-';

    /**
     * @var string $enpassantY The enpassant square for yellow.
     */
    public static $enpassantY = '-';

    /**
     * @var string $enpassantG The enpassant square for green.
     */
    public static $enpassantG = '-';

    /**
     * @var int $moveNumber The current move number.
     */
    public static $moveNumber = 1;

    /**
     * Check to see if it is a promotion square.
     *
     * @param string $square The square to check.
     * @param string $color  The color to check.
     *
     * @return bool Returns true if it is annd false if not.
     */
    public static function isPromotionSquare(string $square, string $color): bool
    {
        return \in_array($square, self::$promotionSquares[$color]);
    }

    /**
     * Translate the letter to a number.
     *
     * @param string $letter The letter to translate.
     *
     * @return int Return the translated data.
     */
    public static function translateToNumber(string $letter): int
    {
        return self::$translateToNumber[$letter];
    }

    /**
     * Translate the number to a letter.
     *
     * @param int $number The number to translate.
     *
     * @return string Return the translated data.
     */
    public static function translateToLetter(int $number): string
    {
        return self::$translateToLetter[$number];
    }

    /**
     * Check to se if that square is not being occupied by a piece.
     *
     * @param string $square The square to check.
     *
     * @return mixed If somebodies home then returns square info or else returns false if not. 
     */
    public static function getSquareInfo(string $square)
    {
        if (Game::$board[$square] != $square) {
            $piece = Game::$board[$square];
            $color = $piece[0];
            if ($piece[1] == 'P') {
                $piece = self::$pieces[$piece][1];
            } else {
                $piece = $piece[1];
            }
            return [
                'color' => $color,
                'piece' => $piece,
            ];
        }
        return false;
    }

    /**
     * Check to se if that square is not being occupied by a piece.
     *
     * @param string $square The square to check.
     *
     * @return bool Returns true if somebodies home and false if not.
     */
    public static function isEmptySquare(string $square): bool
    {
        return (!isset(Game::$board[$square])) || (Game::$board[$square] == $square);
    }

    /**
     * Check the square to see if it is not on the board.
     *
     * @param string $square The square to check.
     *
     * @return bool Returns true if we are no longer on the board otherwise false.
     */
    public static function isOffBoardSquare(string $square): bool
    {
        return (!isset(Game::$board[$square]));
    }

    /**
     * Start the transaction.
     *
     * @return void Returns nothing.
     */
    public static function startTransaction(): void
    {
        self::$saveState['castle']     = self::$castle;
        self::$saveState['move']       = self::$move;
        self::$saveState['moveNum']    = self::$moveNumber;
        self::$saveState['enpassantR'] = self::$enpassantR;
        self::$saveState['enpassantB'] = self::$enpassantB;
        self::$saveState['enpassantY'] = self::$enpassantY;
        self::$saveState['enpassantG'] = self::$enpassantG;
        self::$saveState['pieces']     = self::$pieces;
        self::$saveState['halfMoves']  = self::$halfMoves;
        self::$saveState['positions']  = self::$boardPositions;
        self::$saveState['board']      = Game::$board;
    }

    /**
     * Rollback the transaction.
     *
     * @return void Returns nothing.
     */
    public static function rollbackTransaction(): void
    {
        self::$castle         = self::$saveState['castle'];
        self::$move           = self::$saveState['move'];
        self::$moveNumber     = self::$saveState['moveNum'];
        self::$enpassantR     = self::$saveState['enpassantR'];
        self::$enpassantB     = self::$saveState['enpassantB'];
        self::$enpassantY     = self::$saveState['enpassantY'];
        self::$enpassantG     = self::$saveState['enpassantG'];
        self::$pieces         = self::$saveState['pieces'];
        self::$halfMoves      = self::$saveState['halfMoves'];
        self::$boardPositions = self::$saveState['positions'];
        Game::$board          = self::$saveState['board'];
    }

    /**
     * Commit the transaction.
     *
     * @return void Returns nothing.
     */
    public static function commitTransaction(): void
    {
        self::$saveState = [];
    }
}
