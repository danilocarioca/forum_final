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
     * @param string $questionId
     * @param string $body
     * @param bool $closed
     * @param bool $archived
     */
    public function __construct(
        private readonly UserId $ownerUserId,
        private readonly AnswerId $answerId,
        private readonly string $questionId,
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
     * questionId
     *
     * @return string
     */
    public function questionId(): string
    {
        return $this->questionId;
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
            'questionId' => $this->questionId,
            'body' => $this->body,
            'closed' => $this->closed,
            'archived' => $this->archived
        ];
    }
}
