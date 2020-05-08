<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EventService
 * @package App\Services
 */
class EventService implements EventServiceInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * EventService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Event $topic): Event
    {
        $this->entityManager->persist($topic);
        $this->entityManager->flush();

        return $topic;
    }
}
