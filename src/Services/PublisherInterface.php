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
    /**
     * @param Subscriber $subscriber
     * @param Topic $topic
     * @return bool
     */
    public function subscribe(Subscriber $subscriber, Topic $topic): bool;

    /**
     * @param Message $message
     * @param Topic $topic
     * @return bool
     */
    public function publish(Message $message, Topic $topic): bool;

    /**
     * @param Message $message
     * @return bool
     */
    public function emmitMessage(Message $message): bool;

    /**
     * @param Event $event
     * @return bool
     */
    public function registerEvent(Event $event): bool;
}
