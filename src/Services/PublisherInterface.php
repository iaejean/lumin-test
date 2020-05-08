<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Event;
use App\Entity\Message;
use App\Entity\Subscriber;
use App\Entity\Topic;

/**
 * Interface PublisherInterface
 * @package App\Services
 */
interface PublisherInterface
{
    public function subscribe(Subscriber $subscriber, Topic $topic): bool;

    public function publish(Message $message, Topic $topic): bool;

    public function emmitMessage(Message $message): bool;

    public function registerEvent(Event $event): bool;
}
