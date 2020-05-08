<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Event;

/**
 * Interface EventServiceInterface
 * @package App\Services
 */
interface EventServiceInterface
{
    /**
     * @param Event $topic
     * @return Event
     */
    public function add(Event $topic): Event;
}
