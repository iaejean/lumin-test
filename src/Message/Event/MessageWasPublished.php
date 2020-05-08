<?php

declare(strict_types=1);

namespace App\Message\Event;

use App\Entity\Message;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MessageWasPublished
 * @package App\Message\Event
 */
class MessageWasPublished
{
    /**
     * @Assert\Valid(groups={"default"})
     * @var Message
     */
    private Message $message;

    /**
     * MessageWasPublished constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }
}
