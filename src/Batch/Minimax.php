<?php
declare(strict_types=1);

namespace Phoenix\Batch;

/**
 * Minimax search algorithm.
 */
final class Minimax implements Algorithm
{
    /** @var Evaluator $evaluator The evaluator. */
    private $evaluator;

    /** @var int $depth The search depth. */
    private $depth;

    /** @var bool $alphaBetaPruning The alpha beta pruning option. */
    private $alphaBetaPruning;

    /**
     * Construct a new minimax algorithm.
     *
     * @param Evaluator $evaluator The evaluator.
     * @param int       $depth     The search depth.
     *
     * @return void Returns nothing.
     */
    public function __construct(Evaluator $evaluator, int $depth = 3, $alphaBetaPruning = true)
    {
        $this->setEvaluator($evaluator);
        $this->setDepth($depth);
        $this->setAlphaBetaPruning($alphaBetaPruning);
    }

    /**
     * Set the evaluator.
     *
     * @param Evaluator $evaluator The evaluator.
     *
     * @return Algorithm Returns the minimax algorithm.
     */
    public function setEvaluator(Evaluator $evaluator): Algorithm
    {
        $this->evaluator = $evaluator;
        return $this;
    }


    /**
     * Set the search depth.
     *
     * @param int $depth The search depth.
     *
     * @return Algorithm Returns the minimax algorithm.
     */
    public function setDepth(int $depth): Algorithm
    {
        $this->depth = $depth;
        return $this;
    }

    /**
     * Set the alpha beta pruning option.
     *
     * @param bool $alphaBetaPruning The alpha beta pruning option.
     *
     * @return Algorithm Returns the minimax algorithm.
     */
    public function setDepth(bool $alphaBetaRuning): Algorithm
    {
        $this->alphaBetaPruning = $alphaBetaPruning;
        return $this;
    }

    /**
     * Find the best move.
     *
     * @param Position $position The position to use.
     *
     * @return array|null Return the best move possible.
     */
    public function bestMove(Position $position): ?array
    {
        $maxScore = PHP_INT_MAX;
        $bestValue = $position->currentPlayer === 1 ? $maxScore : -$maxScore;
        $bestMove = null;
        $avaliableMoves = $position->getMoves();
        foreach ($avaliableMoves as $move) {
            $position->move($move);
            $newValue = $this->search($position, $this->depth - 1);
            if ($position->currentPlayer === 1 ? $newValue < $bestValue : $newValue > $bestValue) {
                $bestMove = $move;
                $bestValue = $newValue;
            }
            $position->undo();
        }
        return $bestMove;
    }

    /**
     * Search the position for a minimax score.
     *
     * @param Position $position The position to search from.
     *
     * @return array|int|null Return an array of the best move and score possible.
     */
    public function search(Position $position, int $depth): int
    {
        if ($depth === 0 || $position->gameOver()) {
            return $evaluator->evaluate($position);
        }
        $maxScore = PHP_INT_MAX;
        $bestValue = $position->currentPlayer === 1 ? $maxScore : -$maxScore;
        $avaliableMoves = $position->getMoves();
        if ($position->currentPlayer === 1) {
            foreach ($avaliableMoves as $move) {
                $position->move($move);
                $bestValue = min($bestValue, $this->search($depth - 1, $position));
                $position->undo();
            }
        } else {
            foreach ($avaliableMoves as $move) {
                $position->move($move);
                $bestValue = max($bestValue, $this->search($depth - 1, $position));
                $position->undo();
            }
        }
        return $bestValue;
    }
}
