<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204141211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, type_media_id INT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6A2CA10C2760FA89 (type_media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick_media (trick_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_A103A1B3B281BE2E (trick_id), INDEX IDX_A103A1B3EA9FDD75 (media_id), PRIMARY KEY(trick_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_media (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C2760FA89 FOREIGN KEY (type_media_id) REFERENCES type_media (id)');
        $this->addSql('ALTER TABLE trick_media ADD CONSTRAINT FK_A103A1B3B281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_media ADD CONSTRAINT FK_A103A1B3EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C2760FA89');
        $this->addSql('ALTER TABLE trick_media DROP FOREIGN KEY FK_A103A1B3B281BE2E');
        $this->addSql('ALTER TABLE trick_media DROP FOREIGN KEY FK_A103A1B3EA9FDD75');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE trick_media');
        $this->addSql('DROP TABLE type_media');
    }
}
