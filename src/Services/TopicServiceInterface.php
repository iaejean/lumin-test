<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Topic;

/**
 * Interface TopicServiceInterface
 * @package App\Services
 */
interface TopicServiceInterface
{
    public function add(Topic $topic): Topic;

    public function getByName(string $name): ?Topic;
}
