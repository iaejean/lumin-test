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
     */
    private Message $message;

    /**
     * MessageWasPublished constructor.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
