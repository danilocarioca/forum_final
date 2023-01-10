<?php

namespace App\Application\Answers;


use App\Application\Command;
use App\Application\CommandHandler;
use App\Application\CommandHandlerMethods;
use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerRepository;
use App\Domain\Questions\Question;
use App\Domain\UserManagement\UserRepository;
use Psr\EventDispatcher\EventDispatcherInterface;

class PlaceAnswerHandler implements CommandHandler
{
    use CommandHandlerMethods;


    public function __construct(
        private UserRepository $users,
        private AnswerRepository $answers,
        private EventDispatcherInterface $dispatcher,

    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(Command|PlaceAnswerCommand $command): Answer
    {
        $owner = $this->users->withId($command->ownerUserId());
        $answer = new Answer($owner,$command-> $command->body());
        $this->dispatchEventsFrom($this->answers->add($answer), $this->dispatcher);
        return $answer;
    }
}
