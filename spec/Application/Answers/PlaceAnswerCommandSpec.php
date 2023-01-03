<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\PlaceAnswerCommand;
use PhpSpec\ObjectBehavior;

class PlaceAnswerCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PlaceAnswerCommand::class);
    }
}
