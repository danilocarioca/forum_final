<?php

namespace App\Application\Answers;

use App\Application\Command;
use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\AsResourceObject;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\Attribute;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\RelationshipIdentifier;

/**
 * PlaceAnswerCommand
 *
 * @package App\Application\Answers
 */
#[AsResourceObject(type: "answers")]
class PlaceAnswerCommand implements Command
{
    /**
     * Creates a PlaceAnswerCommand
     *
     * @param UserId $ownerUserId
     * @param AnswerId $answerId
     * @param QuestionId $questionId
     * @param string $body
     */
    public function __construct(
        #[RelationshipIdentifier(name: "owner", className: UserId::class, type: 'users')]
        private readonly UserId $ownerUserId,

        #[Attribute(required: true)]
        private readonly answerId $answerId,

        #[Attribute(required: true)]
        private readonly QuestionId $questionId,

        #[Attribute(required: true)]
        private readonly string $body
    ) {
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
    public function questionId(): QuestionId
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
}
