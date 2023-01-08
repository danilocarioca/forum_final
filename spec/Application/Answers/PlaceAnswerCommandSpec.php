<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\PlaceAnswerCommand;
use App\Application\Command;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use PhpSpec\ObjectBehavior;


class PlaceAnswerCommandSpec extends ObjectBehavior
{
    private $ownerUserId;
    private $answerId;
    private $questionId;
    private $body;

    function let()
    {
        $this->ownerUserId = new UserId();
        $this->answerId = new AnswerId();
        $this->questionId = new QuestionId();
        $this->body = 'Some text as body...';
        $this->beConstructedWith(
            $this->ownerUserId,
            $this->answerId,
            $this->questionId,
            $this->body
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PlaceAnswerCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_ownerUserId()
    {
        $this->ownerUserId()->shouldBe($this->ownerUserId);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_questionId()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }
}
