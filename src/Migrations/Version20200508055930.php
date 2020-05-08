<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20200508055930
 * @package DoctrineMigrations
 */
final class Version20200508055930 extends AbstractMigration
{
    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Create DB Schema';
    }

    /**
     * @inheritDoc
     */
    public function up(Schema $schema): void
    {
        $this->addSql('
            #CREATE DATABASE IF NOT EXISTS publisher;
            
            CREATE TABLE event (
                uuid VARCHAR(45) NOT NULL PRIMARY KEY,
                content VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                created_at DATETIME NOT NULL DEFAULT current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE topic (
                uuid VARCHAR(45) NOT NULL PRIMARY KEY,
                name VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                created_at DATETIME NOT NULL DEFAULT current_timestamp()     
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE subscriber (
                uuid VARCHAR(45) NOT NULL PRIMARY KEY,
                url VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                created_at DATETIME NOT NULL DEFAULT current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            
            CREATE TABLE topic_has_subscriber (
                topic_uuid VARCHAR(45) NOT NULL,
                subscriber_uuid VARCHAR(45) NOT NULL,
                PRIMARY KEY (topic_uuid, subscriber_uuid),
                created_at DATETIME NOT NULL DEFAULT current_timestamp(),
                KEY fk_topic_has_subscriber_topic_uuid_idx (topic_uuid),
                KEY fk_topic_has_subscriber_subscriber_uuid_idx (subscriber_uuid),
                CONSTRAINT fk_topic_has_subscriber_topic_uuid FOREIGN KEY (topic_uuid) REFERENCES topic (uuid) ON DELETE NO ACTION ON UPDATE NO ACTION,
                CONSTRAINT fk_topic_has_subscriber_subscriber_uuid FOREIGN KEY (subscriber_uuid) REFERENCES subscriber (uuid) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;                               
        ');
    }

    /**
     * @inheritDoc
     */
    public function down(Schema $schema): void
    {
        $this->addSql('
            DROP TABLE IF EXISTS topic_has_subscriber;
            DROP TABLE IF EXISTS subscriber;
            DROP TABLE IF EXISTS topic;
            DROP TABLE IF EXISTS event;
        ');
    }
}
