<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Subscriber;

/**
 * Interface SubscriberServiceInterface
 * @package App\Services
 */
interface SubscriberServiceInterface
{
    /**
     * @param Subscriber $subscriber
     * @return Subscriber
     */
    public function add(Subscriber $subscriber): Subscriber;

    /**
     * @param string $url
     * @return Subscriber|null
     */
    public function getByUrl(string $url): ?Subscriber;
}
