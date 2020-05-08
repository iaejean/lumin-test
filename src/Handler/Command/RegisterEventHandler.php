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
    private PublisherInterface $publisher;

    /**
     * RegisterEventHandler constructor.
     */
    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    public function __invoke(RegisterEvent $message)
    {
        $this->publisher->registerEvent($message->getEvent());
    }
}
