<?php

declare(strict_types=1);

namespace App\Handler\Command;

use App\Message\Command\SubscribeEvent;
use App\Services\PublisherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class SubscribeEventHandler
 * @package App\hanlder\Command
 */
final class SubscribeEventHandler implements MessageHandlerInterface
{
    /**
     * @var PublisherInterface
     */
    private PublisherInterface $publisher;

    /**
     * SubscribeEventHandler constructor.
     * @param PublisherInterface $publisher
     */
    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @param SubscribeEvent $message
     */
    public function __invoke(SubscribeEvent $message)
    {
        $this->publisher->subscribe($message->getSubscriber(), $message->getTopic());
    }
}
