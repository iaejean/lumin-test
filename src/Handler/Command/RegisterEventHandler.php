<?php

declare(strict_types=1);

namespace App\Handler\Command;

use App\Message\Command\RegisterEvent;
use App\Services\PublisherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class RegisterEventHandler
 * @package App\hanlder\Command
 */
final class RegisterEventHandler implements MessageHandlerInterface
{
    /**
     * @var PublisherInterface
     */
    private PublisherInterface $publisher;

    /**
     * RegisterEventHandler constructor.
     * @param PublisherInterface $publisher
     */
    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @param RegisterEvent $message
     */
    public function __invoke(RegisterEvent $message)
    {
        $this->publisher->registerEvent($message->getEvent());
    }
}
