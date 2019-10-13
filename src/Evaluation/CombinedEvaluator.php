<?php
declare(strict_types=1);

namespace Phoenix\Evaluation;

use Phoenix\Batch\Evaluator;
use Phoenix\Batch\Position;

final class CombinedEvaluator implements Evaluator
{
    /**
     * @var Evaluator[]
     */
    private $evaluators;

    /**
     * Consturct multiple evaluators.
     *
     * @return void Returns nothing.
     */
    public function __construct(array $evaluators)
    {
        $this->evaluators = \array_map(function (Evaluator $evaluator): Evaluator {
            return $evaluator;
        }, $evaluators);
    }

    /**
     * {@inheritDoc}.
     */
    public function evaluate(Position $position): int
    {
        $sum = 0;
        foreach ($this->evaluators as $evaluator) {
            $sum += $evaluator->evaluate($position);
        }
        return $sum;
    }
}

