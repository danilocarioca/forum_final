<?php

/**
 * This file is part of forum
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\Answers\Models;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\UserManagement\User\Email;
use App\Domain\UserManagement\User\UserId;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\AsResourceObject;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\Attribute;
use App\Infrastructure\JsonApi\SchemaDiscovery\Attributes\ResourceIdentifier;

/**
 * AnswerEntry
 *
 * @package App\Application\Answers\Models
 */
#[AsResourceObject(type: "answers")]
final class AnswerEntry
{

    #[ResourceIdentifier]
    private readonly AnswerId $answerId;
    #[Attribute]
    private readonly string $title;
    #[Attribute]
    private readonly string $body;
    #[Attribute]
    private readonly UserId $userId;
    #[Attribute]
    private readonly string $name;
    #[Attribute]
    private readonly Email $email;

    public function __construct(array $data)
    {
        $this->answerId = new AnswerId($data['answerId']);
        $this->userId = new UserId($data['userId']);
        $this->email = new Email($data['email']);
        $this->title = $data['title'];
        $this->name = $data['name'];
        $this->body = $data['body'];
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
     * userId
     *
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * email
     *
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }
}
