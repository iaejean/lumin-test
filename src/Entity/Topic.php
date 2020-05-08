<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Topic
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="topic")
 * @UniqueEntity(fields={"name"})
 */
class Topic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(name="uuid", type="text", length=45, nullable=false)
     * @Assert\NotBlank()
     */
    private string $uuid;

    /**
     * @ORM\Column(name="name", type="text", length=200, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(maxMessage="200", min="0")
     */
    private string $name;

    /**
     * @ORM\ManyToMany(targetEntity="Subscriber", inversedBy="topics")
     * @ORM\JoinTable(name="topic_has_subscriber",
     *   joinColumns={
     *     @ORM\JoinColumn(name="topic_uuid", referencedColumnName="uuid")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="subscriber_uuid", referencedColumnName="uuid")
     *   }
     * )
     */
    private ?Collection $subscribers;

    /**
     * Topic constructor.
     */
    private function __construct()
    {
        $this->subscribers = new ArrayCollection();
    }

    public static function create(string $name, ?Collection $subscribers = null): Topic
    {
        $topic = new Topic();
        $topic->name = $name;
        $topic->subscribers = $subscribers ?? new ArrayCollection();

        return  $topic;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ?Collection
     */
    public function getSubscribers(): ?Collection
    {
        return $this->subscribers;
    }

    public function addSubscriber(Subscriber $subscriber): Topic
    {
        $this->subscribers->add($subscriber);

        return $this;
    }
}
