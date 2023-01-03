<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\RemoveAnswerCommand;
use PhpSpec\ObjectBehavior;

class RemoveAnswerCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveAnswerCommand::class);
    }
}
