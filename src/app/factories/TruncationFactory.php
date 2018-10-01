<?php
declare(strict_types=1);

namespace src\app\factories;

use TS\Text\Truncation;

/**
 * Class TruncationFactory
 * @untested
 */
class TruncationFactory
{
    /**
     * Creates an instance of Truncation
     * @param int $maxLength
     * @param string $strategy Defaults to word
     * @param string $truncationString
     * @param int $minLength
     * @return Truncation
     * @throws \Exception
     */
    public function make(
        int $maxLength,
        string $strategy = 'word',
        string $truncationString = '…',
        int $minLength = 0
    ): Truncation {
        $strategies = [
            'char' => Truncation::STRATEGY_CHARACTER,
            'line' => Truncation::STRATEGY_LINE,
            'paragraph' => Truncation::STRATEGY_PARAGRAPH,
            'sentence' => Truncation::STRATEGY_SENTENCE,
            'word' => Truncation::STRATEGY_WORD,
        ];

        return new Truncation(
            $maxLength,
            $strategies[$strategy],
            $truncationString,
            'UTF-8',
            $minLength
        );
    }
}
