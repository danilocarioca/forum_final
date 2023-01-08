<?php

namespace spec\App\Domain\Answers\Events;

use App\Domain\AbstractEvent;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\Events\AnswerWasPlaced;
use App\Domain\DomainEvent;
use App\Domain\UserManagement\User\UserId;
use DateTimeImmutable;
use JsonSerializable;
use PhpSpec\ObjectBehavior;

class AnswerWasPlacedSpec extends ObjectBehavior
{

    private $ownerUserId;
    private $answerId;
    private $questionId;
    private $body;
    private $closed;
    private $archived;

    function let()
    {
        $this->ownerUserId = new UserId();
        $this->answerId = new AnswerId();
        $this->questionId = 'a question id number...';
        $this->body = 'A long text as body...';
        $this->closed = false;
        $this->archived = false;
        $this->beConstructedWith(
            $this->ownerUserId,
            $this->answerId,
            $this->questionId,
            $this->body,
            $this->closed,
            $this->archived
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasPlaced::class);
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

    function it_has_a_closed()
    {
        $this->isClosed()->shouldBe($this->closed);
    }

    function it_has_a_archived()
    {
        $this->isArchived()->shouldBe($this->archived);
    }

    function its_an_event()
    {
        $this->shouldBeAnInstanceOf(DomainEvent::class);
        $this->shouldHaveType(AbstractEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(DateTimeImmutable::class);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'ownerUserId' => $this->ownerUserId,
            'answerId' => $this->answerId,
            'questionId' => $this->questionId,
            'body' => $this->body,
            'closed' => $this->closed,
            'archived' => $this->archived
        ]);
    }
}
