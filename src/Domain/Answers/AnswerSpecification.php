<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\Answers;

/**
 * AnswerSpecification
 *
 * @package App\Domain\Answers
 */
interface AnswerSpecification
{

    /**
     * This specification is satisfied by provided answer
     *
     * @param Answer $answer
     * @return bool
     */
    public function isSatisfiedBy(Answer $answer): bool;
}
