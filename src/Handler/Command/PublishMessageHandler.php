<?php

declare(strict_types=1);

namespace App\Handler\Command;

use App\Message\Command\PublishMessage;
use App\Services\PublisherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class PublishMessageHandler
 * @package App\Handler\Command
 */
final class PublishMessageHandler implements MessageHandlerInterface
{
    private PublisherInterface $publisher;

    /**
     * PublishMessageHandler constructor.
     */
    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    public function __invoke(PublishMessage $message): void
    {
        $this->publisher->publish($message->getMessage(), $message->getTopic());
    }
}
