<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Subscriber
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="subscriber")
 * @UniqueEntity(fields={"url", "topic"})
 */
class Subscriber
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(name="uuid", type="text", length=45, nullable=false)
     * @var string $uuid
     */
    private string $uuid;

    /**
     * @ORM\Column(name="url", type="text", length=500, nullable=false)
     * @Assert\NotBlank(groups={"default"})
     * @Assert\Url(groups={"default"})
     * @Groups({"default"})
     * @var string
     */
    private string $url;

    /**
     * @ORM\ManyToMany(targetEntity="Topic", mappedBy="subscribers")
     * @var Collection|null
     */
    private ?Collection $topics;

    /**
     * Subscriber constructor.
     */
    private function __construct()
    {
        $this->topics = new ArrayCollection();
    }

    /**
     * @param string $url
     * @param Collection $topics
     * @return Subscriber
     */
    public static function create(string $url, Collection $topics): Subscriber
    {
        $subscriber = new Subscriber();
        $subscriber->url = $url;
        $subscriber->topics = $topics ?? new ArrayCollection();
        return $subscriber;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUuid(): string 
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return ?Collection
     */
    public function getTopics(): ?Collection
    {
        return $this->topics;
    }

    /**
     * @param Topic $topic
     * @return Subscriber
     */
    public function addTopic(Topic $topic): Subscriber
    {
        $this->topics->add($topic);
        return $this;
    }
}
