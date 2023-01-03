<?php

namespace App\Domain\Answers;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\Events\AnswerWasChanged;
use App\Domain\Answers\Events\AnswerWasPlaced;
use App\Domain\RootAggregate;
use App\Domain\RootAggregateMethods;
use App\Domain\UserManagement\User;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\AsResourceObject;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\Attribute;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\Relationship;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\ResourceIdentifier;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[
    Entity,
    Table(name: "answers")
]
#[AsResourceObject(type: 'answers', links: [AsResourceObject::LINK_SELF], isCompound: true)]
class Answer implements JsonSerializable, RootAggregate
{

    use RootAggregateMethods;

    #[Id, GeneratedValue(strategy: 'NONE'), Column(name: 'id', type: 'AnswerId')]
    #[ResourceIdentifier]
    private AnswerId $answerId;

    #[Column(type: "boolean", options: ["default" => 0])]
    #[Attribute(name: "isClosed")]
    private bool $closed = false;

    #[Column(type: "boolean", options: ["default" => 0])]
    #[Attribute(name: "isArchived")]
    private bool $archived = false;

    private ?Collection $answers = null;

    public function __construct(
        #[ManyToOne(targetEntity: User::class, fetch: "EAGER")]
        #[JoinColumn(name: "owner_id", onDelete: "CASCADE")]
        #[Relationship(
            type: Relationship::TO_ONE,
            links: [AsResourceObject::LINK_RELATED],
            meta: ['description' => "A answer is owned by a user with is it owner."])
        ]
        private User $owner,
        #[Column]
        #[Attribute]
        private string $title,
        #[Column]
        #[Attribute]
        private string $body
    ) {
        $this->answerId = new AnswerId();
        $this->answers = new ArrayCollection();

        $this->recordThat(new AnswerWasPlaced(
            $this->owner->userId(),
            $this->answerId,
            $this->title,
            $this->body,
            $this->closed,
            $this->archived
        ));
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
     * owner
     *
     * @return User
     */
    public function owner(): User
    {
        return $this->owner;
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
     * answers
     *
     * @return Collection
     */
    public function answers(): Collection
    {
        if (!$this->answers) {
            $this->answers = new ArrayCollection();
        }
        return $this->answers;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return [
            'answerId' => $this->answerId,
            'title' => $this->title,
            'body' => $this->body,
            'owner' => $this->owner,
            'archived' => $this->archived,
            'closed' => $this->closed
        ];
    }

    public function change(?string $title = null, ?string $body = null): self
    {
        $this->title = $title ?: $this->title;
        $this->body = $body ?: $this->body;
        $this->recordThat(new AnswerWasChanged($this->answerId, $this->title, $this->body));
        return $this;
    }
}
