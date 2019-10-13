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

    /**
     * Construct a new minimax algorithm.
     *
     * @param Evaluator $evaluator The evaluator.
     * @param int       $depth     The search depth.
     *
     * @return void Returns nothing.
     */
    public function __construct(Evaluator $evaluator, int $depth = 3)
    {
        $this->setEvaluator($evaluator);
        $this->setDepth($depth);
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
     * Find the best move.
     *
     * @param Position $position The position to use.
     *
     * @return array|null Return the best move possible.
     */
    public function bestMove(Position $position): ?array
    {
        $maxScore = 99999;
        $bestValue = $position->currentPlayer() === 1 ? $maxScore : -$maxScore;
        $bestMove = null;
        $avaliableMoves = $position->getMoves();
        foreach ($avaliableMoves as $move) {
            $position->move($move);
            $newValue = $this->search($position, -100000, 100000, $this->depth - 1);
            if ($position->currentPlayer() === 1 ? $newValue < $bestValue : $newValue > $bestValue) {
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
     * @param int      $alpha    The alpha declaration.
     * @param int      $beta     The beta declaration.
     * @param int      $depth    The search depth.
     *
     * @return array|int|null Return an array of the best move and score possible.
     */
    public function search(Position $position, int $alpha, int $beta, int $depth): int
    {
        if ($depth === 0 || $position->gameOver()) {
            return $evaluator->evaluate($position);
        }
        $maxScore = 99999;
        $bestValue = $position->currentPlayer() === 1 ? $maxScore : -$maxScore;
        $avaliableMoves = $position->getMoves();
        if ($position->currentPlayer() === 1) {
            foreach ($avaliableMoves as $move) {
                $position->move($move);
                $bestValue = min($bestValue, $this->search($depth - 1, $alpha, $beta, $position));
                $position->undo();
                $beta = min($beta, $bestValue);
                if ($beta <= $alpha) {
                    return $bestValue;
                }
            }
        } else {
            foreach ($avaliableMoves as $move) {
                $position->move($move);
                $bestValue = max($bestValue, $this->search($depth - 1, $alpha, $beta, $position));
                $position->undo();
                $alpha = max($alpha, $bestValue);
                if ($beta <= $alpha) {
                    return $bestValue;
                }
            }
        }
        return $bestValue;
    }
}
