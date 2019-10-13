<?php declare(strict_types=1);

namespace Phoenix\Game;

use Phoenix\Batch\Position;

/**
 * The chess position.
 */
final class Board implements Position
{
    /** @var array $exportData The export data to save game state. */
    private $exportData;

    /**
     * Construct a new 4 player chess state.
     *
     * @return void Returns nothing.
     */
    public function __construct()
    {
        $this->exportData = Game::exportData(\false);
    }

    /**
     * Get the export data.
     *
     * @return array Returns the export data.
     */
    public function getExportData(): array
    {
        return $this->exportData;
    }

    /**
     * Get the current player or team.
     *
     * @return int Returns the current player.
     */
    public function currentPlayer(): int
    {
        Game::importData($this->exportData);
        if (Utils::$move == 'R' || Utils::$move == 'Y') {
            return 1;
        } else {
            return 2;
        }
    }

    /**
     * Get an array of avaliable moves.
     *
     * @return array Returns an array of avaliable moves.
     */
    public function getMoves(): array
    {
        Game::importData($this->exportData);
        Utils::startTransaction();
        $pmoves = Mover::pawnMoves(Utils::$move);
        $kmoves = Mover::kingMoves(Utils::$move);
        $nmoves = Mover::knightMoves(Utils::$move);
        $qmoves = Mover::queenMoves(Utils::$move);
        $bmoves = Mover::bishopMoves(Utils::$move);
        $rmoves = Mover::rookMoves(Utils::$move);
        $allMoves = [
            $pmoves,
            $kmoves,
            $nmoves,
            $qmoves,
            $bmoves,
            $rmoves,
        ];
        $validMoves = [];
        foreach ($allMoves as $sections) {
            foreach ($sections as $from => $toData) {
                foreach ($toData as $location_a) {
                    if (\is_array($location_a)) {
                        $location_a = $location_a[0];
                    }
                    $to = $location_a;
                    $info = Utils::getSquareInfo($to);
                    if ($info['piece'] == 'P' && Utils::isPromotionSquare($to, $colorToImport)) {
                        foreach ($possiblePromotionSquares as $promotionPiece) {
                            if (Move::move($from, $to, $promotionPiece, \false)) {
                                $validMoves[] = [
                                    $from,
                                    $to,
                                    $promotionPiece
                                ];
                                Utils::rollbackTransaction();
                            }
                        }
                    } else {
                        if (Move::move($from, $to, '', \false)) {
                            $validMoves[] = [
                                $from,
                                $to,
                                $promotionPiece
                            ];
                            Utils::rollbackTransaction();
                        }
                    }
                }
            }
        }
        Utils::commitTransaction();
        return $validMoves;
    }

    /**
     * Make a move on the position.
     *
     * @param array The next move to make or random.
     *
     * @return void Returns nothing.
     */
    public function move(array $move = []): void
    {
        Game::importData($this->exportData);
        if (\in_array($move, $this->getMoves())) {
            Move($move[0], $move[1], $move[2], \true);
            $this->exportData = Game::exportData(\false);
        }
    }

    /**
     * Undo the move that was just made.
     *
     * @return void Returns nothing.
     */
    public function undo(): void
    {
        Game::importData($this->exportData);
        $lastExportData = \array_pop(Utils::$boardPositions);
        $lastExportData = $lastExportData[0];
        $this->exportData = $lastExportData;
    }
}
