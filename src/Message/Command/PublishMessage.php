<?php

declare(strict_types=1);

namespace App\Message\Command;

use App\Entity\Message;
use App\Entity\Topic;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PublishMessage
 * @package App\Message\Command
 */
class PublishMessage
{
    /**
     * @Assert\Valid(groups={"default"})
     * @var Message
     */
    private Message $message;

    /**
     * @Assert\Valid(groups={"default"})
     * @var Topic
     */
    private Topic $topic;

    /**
     * PublishMessage constructor.
     * @param Message $message
     * @param Topic $topic
     */
    public function __construct(Message $message, Topic $topic)
    {
        $this->message = $message;
        $this->topic = $topic;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @return Topic
     */
    public function getTopic(): Topic
    {
        return $this->topic;
    }
}
