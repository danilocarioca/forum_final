<?php

namespace spec\App\Domain\Answers\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerSpecification;
use App\Domain\Answers\Specification\OwnedByRequester;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserIdentifier;
use PhpSpec\ObjectBehavior;

class OwnedByRequesterSpec extends ObjectBehavior
{
    function let(
        UserIdentifier $identifier,
        User $loggedInUser
    ) {
        $loggedInUser->userId()->willReturn(new User\UserId());
        $identifier->currentUser()->willReturn($loggedInUser);

        $this->beConstructedWith($identifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OwnedByRequester::class);
    }

    function its_a_answer_specification()
    {
        $this->shouldBeAnInstanceOf(AnswerSpecification::class);
    }

    function it_is_satisfied_when_answer_owner_is_the_logged_in_user(
        Answer $answer,
        User $loggedInUser
    ) {
        $answer->owner()->willReturn($loggedInUser);
        $this->isSatisfiedBy($answer)->shouldBe(true);
    }

    function it_fails_when_owner_is_not_the_logged_in_user(
        Answer $answer,
        User $owner
    ) {
        $answer->owner()->willReturn($owner);
        $owner->userId()->willReturn(new User\UserId());
        $this->isSatisfiedBy($answer)->shouldBe(false);
    }
}
