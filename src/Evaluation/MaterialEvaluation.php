<?php declare(strict_types=1);

namespace Phoenix\Evaluation;

use Phoenix\Batch\Evaluator;
use Phoenix\Batch\Position;

use Phoenix\Game\Game;
use Phoenix\Game\Utils;

/**
 * The material evaluation.
 */
final class MaterialEvaluation implements Evaluator
{
    /** @var array $pieceValues A list of values associated with the pieces. */
    private static $pieceValues = [
        [
            'K' => 10000,
            'Q' => 1000,
            'R' => 525,
            'B' => 425,
            'N' => 325,
            'P' => 100,
        ],
        [
            'K' => -10000,
            'Q' => -1000,
            'R' => -525,
            'B' => -425,
            'N' => -325,
            'P' => -100,
        ],
    ];

    /**
     * {@inheritDoc}.
     */
    public function evaluate(Position $position): int
    {
        Game::importData($position->getExportData);
        $sum = 0;
        foreach (Utils::$pieces as $pieceKey => $pieceData) {
            $color = substr($pieceKey, 0, 1);
            $piece = substr($pieceKey, 1, 1);
            if (is_array($pieceData)) {
                $type = $pieceData[1];
                if ($color == 'R' || $color == 'Y') {
                    $value = self::$pieceValues[0][$type];
                } else {
                    $value = self::$pieceValues[1][$type];
                }
            } elseif (is_string($pieceData)) {
                if ($color == 'R' || $color == 'Y') {
                    $value = self::$pieceValues[0][$piece];
                } else {
                    $value = self::$pieceValues[1][$piece];
                }
            } else {
                $value = 0;
            }
            $sum += $value;
        }
        return $sum;
    }
}
