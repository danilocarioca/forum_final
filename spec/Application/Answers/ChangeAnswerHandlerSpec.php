<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\ChangeAnswerCommand;
use App\Application\Answers\ChangeAnswerHandler;
use App\Application\CommandHandler;
use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerRepository;
use App\Domain\Answers\Events\AnswerWasChanged;
use App\Domain\Answers\Specification\OwnedByRequester;
use App\Domain\Exception\SpecificationFails;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ChangeAnswerHandlerSpec extends ObjectBehavior
{
    private $answerId;
    private $body;

    function let(
        AnswerRepository $answers,
        OwnedByRequester $ownedByRequester,
        EventDispatcher $dispatcher,
        Answer $answer,
        AnswerWasChanged $event
    ) {
        $this->answerId = new Answer\AnswerId();
        $this->body = 'some body';

        $answers->withAnswerId($this->answerId)->willReturn($answer);

        $answer->answerId()->willReturn($this->answerId);
        $answer->change($this->body)->willReturn($answer);
        $answer->releaseEvents()->willReturn([$event]);

        $dispatcher->dispatch(Argument::any())->willReturnArgument();

        $ownedByRequester->isSatisfiedBy($answer)->willReturn(true);

        $this->beConstructedWith($answers, $ownedByRequester, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChangeAnswerHandler::class);
    }

    function its_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_handles_change_answer_command(
        Answer $answer
    ) {
        $command = new ChangeAnswerCommand(
            $this->answerId,
            $this->body
        );

        $this->handle($command)->shouldBe($answer);
        $answer->change($this->body)->shouldBeCalled();
    }

    function it_triggers_change_events(
        EventDispatcher $dispatcher,
        AnswerWasChanged $event
    ) {
        $command = new ChangeAnswerCommand(
            $this->answerId,
            $this->body
        );

        $this->handle($command);
        $dispatcher->dispatch($event)->shouldHaveBeenCalled();
    }


    function it_throws_exception_when_changing_user_is_not_the_owner(
        OwnedByRequester $ownedByRequester,
        Answer $answer
    ) {
        $ownedByRequester->isSatisfiedBy($answer)->willReturn(false);

        $command = new ChangeAnswerCommand(
            $this->answerId,
            $this->body
        );
        $this->shouldThrow(SpecificationFails::class)
            ->during('handle', [$command]);
    }

}
