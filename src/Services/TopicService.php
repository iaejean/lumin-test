<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Topic;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TopicService
 * @package App\Services
 */
class TopicService implements TopicServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * TopicService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function add(Topic $topic): Topic
    {
        $this->entityManager->persist($topic);
        $this->entityManager->flush();
        return $topic;
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name): ?Topic
    {
        $topicRepository = $this->entityManager->getRepository(Topic::class);
        /** @var Topic|null $topic */
        $topic = $topicRepository->findOneBy(['name' => $name]);
        return $topic;
    }
}
