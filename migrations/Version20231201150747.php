<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201150747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trick_group (trick_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_A6EF447AB281BE2E (trick_id), INDEX IDX_A6EF447AFE54D947 (group_id), PRIMARY KEY(trick_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trick_group ADD CONSTRAINT FK_A6EF447AB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trick_group ADD CONSTRAINT FK_A6EF447AFE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick_group DROP FOREIGN KEY FK_A6EF447AB281BE2E');
        $this->addSql('ALTER TABLE trick_group DROP FOREIGN KEY FK_A6EF447AFE54D947');
        $this->addSql('DROP TABLE trick_group');
    }
}
