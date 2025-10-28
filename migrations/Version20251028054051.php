<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251028054051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE big_folk_district (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE blackout (id SERIAL NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, initiator_name VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE blackout_building (blackout_id INT NOT NULL, building_id INT NOT NULL, PRIMARY KEY(blackout_id, building_id))');
        $this->addSql('CREATE INDEX IDX_11A1210F81E4A992 ON blackout_building (blackout_id)');
        $this->addSql('CREATE INDEX IDX_11A1210F4D2A7E12 ON blackout_building (building_id)');
        $this->addSql('CREATE TABLE building (id SERIAL NOT NULL, street_id INT NOT NULL, district_id INT NOT NULL, folk_district_id INT DEFAULT NULL, big_folk_district_id INT DEFAULT NULL, city_id INT NOT NULL, number VARCHAR(255) NOT NULL, is_fake BOOLEAN NOT NULL, type VARCHAR(255) NOT NULL, coordinates VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E16F61D487CF8EB ON building (street_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D4B08FA272 ON building (district_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D44A288452 ON building (folk_district_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D47333D892 ON building (big_folk_district_id)');
        $this->addSql('CREATE INDEX IDX_E16F61D48BAC62AF ON building (city_id)');
        $this->addSql('CREATE TABLE city (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE district (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE folk_district (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE street (id SERIAL NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0EED3D88BAC62AF ON street (city_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE blackout_building ADD CONSTRAINT FK_11A1210F81E4A992 FOREIGN KEY (blackout_id) REFERENCES blackout (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blackout_building ADD CONSTRAINT FK_11A1210F4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D487CF8EB FOREIGN KEY (street_id) REFERENCES street (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4B08FA272 FOREIGN KEY (district_id) REFERENCES district (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D44A288452 FOREIGN KEY (folk_district_id) REFERENCES folk_district (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D47333D892 FOREIGN KEY (big_folk_district_id) REFERENCES big_folk_district (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D48BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE street ADD CONSTRAINT FK_F0EED3D88BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE blackout_building DROP CONSTRAINT FK_11A1210F81E4A992');
        $this->addSql('ALTER TABLE blackout_building DROP CONSTRAINT FK_11A1210F4D2A7E12');
        $this->addSql('ALTER TABLE building DROP CONSTRAINT FK_E16F61D487CF8EB');
        $this->addSql('ALTER TABLE building DROP CONSTRAINT FK_E16F61D4B08FA272');
        $this->addSql('ALTER TABLE building DROP CONSTRAINT FK_E16F61D44A288452');
        $this->addSql('ALTER TABLE building DROP CONSTRAINT FK_E16F61D47333D892');
        $this->addSql('ALTER TABLE building DROP CONSTRAINT FK_E16F61D48BAC62AF');
        $this->addSql('ALTER TABLE street DROP CONSTRAINT FK_F0EED3D88BAC62AF');
        $this->addSql('DROP TABLE big_folk_district');
        $this->addSql('DROP TABLE blackout');
        $this->addSql('DROP TABLE blackout_building');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE folk_district');
        $this->addSql('DROP TABLE street');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
