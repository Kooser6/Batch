<?php
declare(strict_types=1);

namespace Phoenix\Evaluation;

use Phoenix\Batch\Evaluator;
use Phoenix\Batch\Position;

use Phoenix\Game\Utils;
use Phoenix\Game\Threat;

/**
 * The material connection evaluation.
 */
class MaterialConnectionEvaluation implements Evaluator
{
    /**
     * {@inheritDoc}.
     */
    public function evaluate(Position $position): int
    {
        Game::importData($position->getExportData);
        $sum = 0;
        foreach (Utils::$pieces as $pieceKey => $pieceData) {
            $color = substr($pieceKey, 0, 1);
            if (!$pieceData) {
                continue;
            }
            if ($color == 'R' || $color == 'Y') {
                $oppositeColors = [
                    'B',
                    'G',
                ];
            } else {
                $oppositeColors = [
                    'R',
                    'Y',
                ];
            }
            if (is_array($pieceData)) {
                $location = $pieceData[0];
            } else {
                $location = $pieceData;
            }
            $value = 0;
            foreach (Utils::$pieces as $key => $info) {
                if ($info) {
                    $color2 = substr($key, 0, 1);
                    if (is_array($info)) {
                        $info = $info[0];
                    }
                    if ($info == $location) {
                        continue;
                    }
                    if (Threat::isThreat($info, $location)) {
                        if (in_array($color2, $oppositeColors)) {
                            if ($color == 'R' || $color == 'Y') {
                                $value += -25;
                            } else {
                                $value += 25;
                            }
                        } else {
                            if ($color == 'R' || $color == 'Y') {
                                $value += 25;
                            } else {
                                $value += -25;
                            }
                        }
                    }
                }
            }
            $sum += $value;
        }
        return $sum;
    }
}
