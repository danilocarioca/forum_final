<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\RemoveAnswerHandler;
use PhpSpec\ObjectBehavior;

class RemoveAnswerHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveAnswerHandler::class);
    }
}
