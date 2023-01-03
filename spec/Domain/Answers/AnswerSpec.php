<?php

namespace spec\App\Domain\Answers;

use App\Domain\Answers\Events\AnswerWasChanged;
use App\Domain\Answers\Events\AnswerWasPlaced;
use App\Domain\Answers\Answer;
use App\Domain\RootAggregate;
use App\Domain\UserManagement\User;
use Doctrine\Common\Collections\Collection;
use PhpSpec\ObjectBehavior;



class AnswerSpec extends ObjectBehavior
{
    private $title;
    private $body;

    function let(User $owner)
    {
        $owner->userId()->willReturn(new User\UserId());

        $this->title = 'Some title';
        $this->body = 'And a body';
        $this->beConstructedWith($owner, $this->title, $this->body);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Answer::class);
    }

    function its_a_root_aggregate()
    {
        $this->shouldBeAnInstanceOf(RootAggregate::class);
        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(AnswerWasPlaced::class);
    }

    function it_has_a_answer_id()
    {
        $this->answerId()->shouldBeAnInstanceOf(Answer\AnswerId::class);
    }

    function it_has_a_title()
    {
        $this->title()->shouldBe($this->title);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }

    function it_has_a_owner(User $owner)
    {
        $this->owner()->shouldBe($owner);
    }

    function it_has_a_closed_state()
    {
        $this->isClosed()->shouldBe(false);
    }

    function it_has_an_archived_state()
    {
        $this->isArchived()->shouldBe(false);
    }

    function it_can_be_converted_to_json(User $owner)
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'answerId' => $this->answerId(),
            'title' => $this->title,
            'body' => $this->body,
            'owner' => $owner,
            'archived' => false,
            'closed' => false
        ]);
    }

    function it_has_a_collection_of_answers()
    {
        $this->answers()->shouldBeAnInstanceOf(Collection::class);
    }

    function it_can_be_changed()
    {
        $title = 'new Title';
        $body = 'new body';
        $this->releaseEvents();
        $this->change($title, $body)->shouldBe($this->getWrappedObject());

        $this->title()->shouldBe($title);
        $this->body()->shouldBe($body);

        $events = $this->releaseEvents();
        $events->shouldHaveCount(1);
        $events[0]->shouldBeAnInstanceOf(AnswerWasChanged::class);
    }

}
