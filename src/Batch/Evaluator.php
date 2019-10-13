<?php declare(strict_types=1);

namespace Phoenix\Batch;

/**
 * Defines an evaluator.
 */
interface Evaluator
{
    /**
     * Evaluate the position.
     *
     * @param Position $position The position to evaluate.
     *
     * @return int Returns the evaluation sum of the position.
     */
    public function evaluate(Position $position): int;
}
