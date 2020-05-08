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
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * @var TopicServiceInterface
     */
    private TopicServiceInterface $topicService;

    /**
     * @var SubscriberServiceInterface
     */
    private SubscriberServiceInterface $subscriberService;

    /**
     * @var EventServiceInterface
     */
    private EventServiceInterface $eventService;

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Publisher constructor.
     * @param EntityManagerInterface $entityManager
     * @param HttpClientInterface $httpClient
     * @param TopicServiceInterface $topicService
     * @param SubscriberServiceInterface $subscriberService
     * @param EventServiceInterface $eventService
     * @param MessageBusInterface $messageBus
     * @param LoggerInterface $logger
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
     * @inheritDoc
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
     * @inheritDoc
     */
    public function publish(Message $message, Topic $topic): bool
    {
        $this->logger->info('Publish a new message');
        $this->messageBus->dispatch(new MessageWasPublished(Message::create($message->getMessage(), $topic)));
        return true;
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function registerEvent(Event $event): bool
    {
        $this->logger->info('Register event');
        $this->eventService->add($event);
        return true;
    }
}
