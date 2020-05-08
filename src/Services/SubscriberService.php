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
    private EntityManagerInterface $entityManager;

    /**
     * SubscriberService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Subscriber $topic): Subscriber
    {
        $this->entityManager->persist($topic);
        $this->entityManager->flush();

        return $topic;
    }

    /**
     * {@inheritdoc}
     */
    public function getByUrl(string $url): ?Subscriber
    {
        $subscriberRepository = $this->entityManager->getRepository(Subscriber::class);
        /** @var Subscriber|null $topic */
        $topic = $subscriberRepository->findOneBy(['url' => $url]);

        return $topic;
    }
}
