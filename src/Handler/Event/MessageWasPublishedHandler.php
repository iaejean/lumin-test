<?php

declare(strict_types=1);

namespace App\Handler\Event;

use App\Message\Event\MessageWasPublished;
use App\Services\PublisherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class MessageWasPublishedHandler
 * @package App\Handler\Event
 */
class MessageWasPublishedHandler implements MessageHandlerInterface
{
    private PublisherInterface $publisher;

    /**
     * MessageWasPublishedHandler constructor.
     */
    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    public function __invoke(MessageWasPublished $message)
    {
        $this->publisher->emmitMessage($message->getMessage());
    }
}
