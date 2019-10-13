<?php
declare(strict_types=1);

namespace Phoenix\Batch;

/**
 * The algorithm.
 */
interface Algorithm
{
    /**
     * Construct a new minimax algorithm.
     *
     * @param Evaluator $evaluator The evaluator.
     * @param int       $depth     The search depth.
     *
     * @return void Returns nothing.
     */
    public function __construct(Evaluator $evaluator, int $depth = 3);

    /**
     * Set the evaluator.
     *
     * @param Evaluator $evaluator The evaluator.
     *
     * @return Algorithm Returns the minimax algorithm.
     */
    public function setEvaluator(Evaluator $evaluator): Algorithm;

    /**
     * Set the search depth.
     *
     * @param int $depth The search depth.
     *
     * @return Algorithm Returns the minimax algorithm.
     */
    public function setDepth(int $depth): Algorithm;

    /**
     * Find the best move.
     *
     * @param Position $position The position to use.
     *
     * @return array|null Return the best move possible.
     */
    public function bestMove(Position $position): ?array;

    /**
     * Search the position for a minimax score.
     *
     * @param Position $position The position to search from.
     * @param int      $alpha    The alpha declaration.
     * @param int      $beta     The beta declaration.
     * @param int      $depth    The search depth.
     *
     * @return array|int|null Return an array of the best move and score possible.
     */
    public function search(Position $position, int $alpha, int $beta, int $depth): int;
}
