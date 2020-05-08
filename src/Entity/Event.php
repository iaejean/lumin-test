<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Event
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(name="uuid", type="text", length=45, nullable=false)
     */
    private string $uuid;

    /**
     * @ORM\Column(name="content", type="json", nullable=false)
     * @Groups({"default"})
     */
    private string $content;

    /**
     * Event constructor.
     */
    private function __construct()
    {
    }

    public function create(string $content): Event
    {
        $event = new Event();
        $event->content = $content;

        return $event;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setContent(string $content): Event
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
