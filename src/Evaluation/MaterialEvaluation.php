<?php declare(strict_types=1);

namespace Phoenix\Evaluation;

use Phoenix\Batch\Evaluator;
use Phoenix\Batch\Position;

/**
 * The material evaluation.
 */
final class MaterialEvaluation implements Evaluator
{
    /** @var array $pieceValues A list of values associated with the pieces. */
    private $pieceValues = [
        [
            'K' => 10000,
            'Q' => 1000,
            'R' => 525,
            'B' => 400,
            'N' => 300,
            'P' => 100,
        ],
        [
            'K' => -10000,
            'Q' => -1000,
            'R' => -525,
            'B' => -400,
            'N' => -300,
            'P' => -100,
        ],
    ];

    /**
     * {@inheritDoc}.
     */
    public function evaluate(Position $position): int
    {
        $sum = 0;
        foreach ($position->pieces() as $key => $data) {
            $piece = $key;
            if ($position->inactive($piece)) {
                continue;
            }
            $piece = substr($piece, 1, 1);
            $location = $data['location'];
            $color = $data['color'];
            if ($color == 'R' || $color == 'Y') {
                $sum += $this->pieceValues[0][$piece];
            } else {
                $sum += $this->pieceValues[1][$piece];
            }
        }
        return $sum;
    }
}
