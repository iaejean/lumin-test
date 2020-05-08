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
     */
    private Message $message;

    /**
     * @Assert\Valid(groups={"default"})
     */
    private Topic $topic;

    /**
     * PublishMessage constructor.
     */
    public function __construct(Message $message, Topic $topic)
    {
        $this->message = $message;
        $this->topic = $topic;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getTopic(): Topic
    {
        return $this->topic;
    }
}
