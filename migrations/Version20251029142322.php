<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251029142322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blackout ADD organization_id INT NOT NULL');
        $this->addSql('ALTER TABLE blackout DROP initiator_name');
        $this->addSql('ALTER TABLE blackout ADD CONSTRAINT FK_C4C4BD532C8A3DE FOREIGN KEY (organization_id) REFERENCES organizations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C4C4BD532C8A3DE ON blackout (organization_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE blackout DROP CONSTRAINT FK_C4C4BD532C8A3DE');
        $this->addSql('DROP INDEX IDX_C4C4BD532C8A3DE');
        $this->addSql('ALTER TABLE blackout ADD initiator_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE blackout DROP organization_id');
    }
}
