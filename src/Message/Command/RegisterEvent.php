<?php

declare(strict_types=1);

namespace App\Message\Command;

use App\Entity\Event;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegisterEvent
 * @package App\Message\Command
 */
class RegisterEvent
{
    /**
     * @Assert\Valid(groups={"default"})
     */
    private Event $event;

    /**
     * RegisterEvent constructor.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }
}
