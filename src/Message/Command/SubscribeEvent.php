<?php

declare(strict_types=1);

namespace App\Message\Command;

use App\Entity\Subscriber;
use App\Entity\Topic;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SubscribeEvent
 * @package App\Message\Command
 */
class SubscribeEvent
{
    /**
     * @Assert\Valid(groups={"default"})
     * @var Subscriber
     */
    private Subscriber $subscriber;

    /**
     * @Assert\Valid(groups={"default"})
     * @var Topic
     */
    private Topic $topic;

    /**
     * SubscribeEvent constructor.
     * @param Subscriber $subscriber
     * @param Topic $topic
     */
    public function __construct(Subscriber $subscriber, Topic $topic)
    {
        $this->subscriber = $subscriber;
        $this->topic = $topic;
    }

    /**
     * @return Subscriber
     */
    public function getSubscriber(): Subscriber
    {
        return $this->subscriber;
    }

    /**
     * @return Topic
     */
    public function getTopic(): Topic
    {
        return $this->topic;
    }
}
