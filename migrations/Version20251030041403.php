<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030041403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blackout DROP CONSTRAINT fk_c4c4bd532c8a3de');
        $this->addSql('DROP INDEX idx_c4c4bd532c8a3de');
        $this->addSql('ALTER TABLE blackout DROP organization_id');
        $this->addSql('ALTER TABLE building ADD organization_id INT NOT NULL');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D432C8A3DE FOREIGN KEY (organization_id) REFERENCES organizations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E16F61D432C8A3DE ON building (organization_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE building DROP CONSTRAINT FK_E16F61D432C8A3DE');
        $this->addSql('DROP INDEX IDX_E16F61D432C8A3DE');
        $this->addSql('ALTER TABLE building DROP organization_id');
        $this->addSql('ALTER TABLE blackout ADD organization_id INT NOT NULL');
        $this->addSql('ALTER TABLE blackout ADD CONSTRAINT fk_c4c4bd532c8a3de FOREIGN KEY (organization_id) REFERENCES organizations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c4c4bd532c8a3de ON blackout (organization_id)');
    }
}
