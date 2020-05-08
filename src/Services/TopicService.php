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
    private EntityManagerInterface $entityManager;

    /**
     * TopicService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Topic $topic): Topic
    {
        $this->entityManager->persist($topic);
        $this->entityManager->flush();

        return $topic;
    }

    /**
     * {@inheritdoc}
     */
    public function getByName(string $name): ?Topic
    {
        $topicRepository = $this->entityManager->getRepository(Topic::class);
        /** @var Topic|null $topic */
        $topic = $topicRepository->findOneBy(['name' => $name]);

        return $topic;
    }
}
