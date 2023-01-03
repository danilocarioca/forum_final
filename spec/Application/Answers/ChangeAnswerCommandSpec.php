<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\ChangeAnswerCommand;
use App\Application\Command;
use App\Domain\Answers\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

class ChangeAnswerCommandSpec extends ObjectBehavior
{
    private $answerId;
    private $title;
    private $body;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->title = 'title';
        $this->body = 'body';
        $this->beConstructedWith($this->answerId, $this->title, $this->body);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeAnswerCommand::class);
    }

    function its_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_has_a_answerId()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_title()
    {
        $this->title()->shouldBe($this->title);
    }

    function it_has_a_body()
    {
        $this->body()->shouldBe($this->body);
    }
}
