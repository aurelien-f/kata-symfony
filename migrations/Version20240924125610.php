<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924125610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add poster, lastPlayedAt, and status fields to movie table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie ADD COLUMN poster VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD COLUMN last_played_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD COLUMN status VARCHAR(10) NOT NULL DEFAULT "unseen"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP COLUMN poster');
        $this->addSql('ALTER TABLE movie DROP COLUMN last_played_at');
        $this->addSql('ALTER TABLE movie DROP COLUMN status');
    }
}