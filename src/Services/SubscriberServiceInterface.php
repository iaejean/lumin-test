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
    public function add(Subscriber $subscriber): Subscriber;

    public function getByUrl(string $url): ?Subscriber;
}
