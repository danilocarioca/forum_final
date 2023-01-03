<?php

namespace App\Domain\Answers\Events;

use App\Domain\AbstractEvent;
use App\Domain\Answers\Answer\AnswerId;

class AnswerWasChanged extends AbstractEvent implements \JsonSerializable
{
    /**
     * Creates a AnswerWasChanged
     *
     * @param AnswerId $answerId
     * @param string $title
     * @param string $body
     */
    public function __construct(
        private readonly AnswerId $answerId,
        private readonly string $title,
        private readonly string $body
    ) {
        parent::__construct();
    }

    /**
     * answerId
     *
     * @return AnswerId
     */
    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    /**
     * title
     *
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'answerId' => $this->answerId,
            'title' => $this->title,
            'body' => $this->body
        ];
    }
}
