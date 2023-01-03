<?php

namespace spec\App\Domain\Answers\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerSpecification;
use App\Domain\Answers\Specification\IsActive;
use PhpSpec\ObjectBehavior;

class IsActiveSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IsActive::class);
    }

    function it_a_answer_specification()
    {
        $this->shouldBeAnInstanceOf(AnswerSpecification::class);
    }

    function it_validates_answer_is_not_open_nor_archived(
        Answer $answer
    ) {
        $answer->isArchived()->willReturn(false);
        $answer->isClosed()->willReturn(false);
        $this->isSatisfiedBy($answer)->shouldBe(true);
    }

    function it_fails_when_answer_is_closed(
        Answer $answer
    ) {
        $answer->isArchived()->willReturn(false);
        $answer->isClosed()->willReturn(true);
        $this->isSatisfiedBy($answer)->shouldBe(false);
    }

    function it_fails_when_answer_is_archived(
        Answer $answer
    ) {
        $answer->isArchived()->willReturn(true);
        $answer->isClosed()->willReturn(false);
        $this->isSatisfiedBy($answer)->shouldBe(false);
    }
}
