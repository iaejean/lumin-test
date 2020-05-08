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
    /**
     * @param Topic $topic
     * @return Topic
     */
    public function add(Topic $topic): Topic;

    /**
     * @param string $name
     * @return Topic|null
     */
    public function getByName(string $name): ?Topic;
}
