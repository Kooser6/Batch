<?php
declare(strict_types=1);

namespace Phoenix\Batch;

/**
 * The position that will be used as batch.
 */
interface Position
{
    /**
     * Get the current player or team.
     *
     * @return int Returns the current player.
     */
    public function currentPlayer(): int;

    /**
     * Get an array of avaliable moves.
     *
     * @return array Returns an array of avaliable moves.
     */
    public function getMoves(): array;

    /**
     * Make a move on the position.
     *
     * @param array The next move to make or random.
     *
     * @return void Returns nothing.
     */
    public function move(array $move = []): void;

    /**
     * Undo the move that was just made.
     *
     * @return void Returns nothing.
     */
    public function undo(): void;
}
