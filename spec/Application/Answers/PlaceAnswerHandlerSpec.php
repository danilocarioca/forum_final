<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\PlaceAnswerHandler;
use PhpSpec\ObjectBehavior;

class PlaceAnswerHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PlaceAnswerHandler::class);
    }
}
