<?php

namespace App\Domain\Answers\Events;

use App\Domain\AbstractEvent;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\UserManagement\User\UserId;
use JsonSerializable;

class AnswerWasPlaced extends AbstractEvent implements JsonSerializable
{

    /**
     * Creates a AnswerWasPlaced
     *
     * @param UserId $ownerUserId
     * @param AnswerId $answerId
     * @param string $title
     * @param string $body
     * @param bool $closed
     * @param bool $archived
     */
    public function __construct(
        private readonly UserId $ownerUserId,
        private readonly AnswerId $answerId,
        private readonly string $title,
        private readonly string $body,
        private readonly bool $closed,
        private readonly bool $archived
    ) {
        parent::__construct();
    }

    /**
     * ownerUserId
     *
     * @return UserId
     */
    public function ownerUserId(): UserId
    {
        return $this->ownerUserId;
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
     * closed
     *
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->closed;
    }

    /**
     * archived
     *
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->archived;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'ownerUserId' => $this->ownerUserId,
            'answerId' => $this->answerId,
            'title' => $this->title,
            'body' => $this->body,
            'closed' => $this->closed,
            'archived' => $this->archived
        ];
    }
}
