<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Event;
use App\Entity\Message;
use App\Entity\Subscriber;
use App\Entity\Topic;
use App\Exceptions\InvalidMessageException;
use App\Message\Event\MessageWasPublished;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class Publisher
 * @package App\Services
 */
class Publisher implements PublisherInterface
{
    private EntityManagerInterface $entityManager;

    private HttpClientInterface $httpClient;

    private TopicServiceInterface $topicService;

    private SubscriberServiceInterface $subscriberService;

    private EventServiceInterface $eventService;

    private MessageBusInterface $messageBus;

    private LoggerInterface $logger;

    /**
     * Publisher constructor.
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        HttpClientInterface $httpClient,
        TopicServiceInterface $topicService,
        SubscriberServiceInterface $subscriberService,
        EventServiceInterface $eventService,
        MessageBusInterface $messageBus,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
        $this->topicService = $topicService;
        $this->subscriberService = $subscriberService;
        $this->eventService = $eventService;
        $this->messageBus = $messageBus;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe(Subscriber $subscriber, Topic $topic): bool
    {
        $this->logger->info('Add new subscriber');

        $newTopic = $topic;
        $topic = $this->topicService->getByName($topic->getName());
        if (!$topic instanceof Topic) {
            $topic = $this->topicService->add($newTopic);
        }

        $newSubscriber = $subscriber;
        $subscriber = $this->subscriberService->getByUrl($subscriber->getUrl());
        if (!$subscriber instanceof Subscriber) {
            $subscriber = $this->subscriberService->add($newSubscriber);
        }

        try {
            $topic->addSubscriber($subscriber);
            $this->topicService->add($topic);
        } catch (\Exception $exception) {
            throw InvalidMessageException::alreadyExist();
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function publish(Message $message, Topic $topic): bool
    {
        $this->logger->info('Publish a new message');
        $this->messageBus->dispatch(new MessageWasPublished(Message::create($message->getMessage(), $topic)));

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function emmitMessage(Message $message): bool
    {
        $this->logger->info('Emit message');
        $topic = $this->topicService->getByName($message->getTopic()->getName());
        if (!$topic instanceof Topic) {
            return false;
        }

        $topic->getSubscribers()
            ->map(
                function (Subscriber $subscriber) use ($message): bool {
                    try {
                        $this->httpClient->request(
                            'POST',
                            $subscriber->getUrl(),
                            [
                                'headers' => ['Content-Type' => 'application/json'],
                                'body' => json_encode(['content' => $message->getMessage()])
                            ]
                        );
                    } catch (\Exception $exception) {
                        $this->logger->warning($exception->getMessage());
                    }

                    return true;
                }
            );

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function registerEvent(Event $event): bool
    {
        $this->logger->info('Register event');
        $this->eventService->add($event);

        return true;
    }
}
