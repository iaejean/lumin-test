<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Subscriber;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SubscriberService
 * @package App\Services
 */
class SubscriberService implements SubscriberServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * SubscriberService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function add(Subscriber $topic): Subscriber
    {
        $this->entityManager->persist($topic);
        $this->entityManager->flush();
        return $topic;
    }

    /**
     * @inheritDoc
     */
    public function getByUrl(string $url): ?Subscriber
    {
        $subscriberRepository = $this->entityManager->getRepository(Subscriber::class);
        /** @var Subscriber|null $topic */
        $topic = $subscriberRepository->findOneBy(['url' => $url]);
        return $topic;
    }
}
