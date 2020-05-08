<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Class Message
 * @package App\Entity
 * ORM\Entity()
 * ORM\Table("message")
 */
class Message
{
    /**
     * ORM\Id()
     * ORM\GeneratedValue(strategy="UUID")
     * ORM\Column(name="uuid", type="text", length=45, nullable=false)
     */
    private string $uuid;

    /**
     * @SerializedName("message")
     * @Groups({"default"})
     */
    protected string $message;

    protected Topic $topic;

    /**
     * Message constructor.
     */
    private function __construct()
    {
    }

    public static function create(string $message, Topic $topic): Message
    {
        $newMessage = new Message();
        $newMessage->message = $message;
        $newMessage->topic = $topic;

        return $newMessage;
    }

    public function setMessage(string $message): Message
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getTopic(): Topic
    {
        return $this->topic;
    }
}
