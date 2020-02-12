<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211102010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');
        $this->addSql('CREATE SEQUENCE etudiant_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE etudiant (id NUMBER(10) NOT NULL, rfid_id NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_21A5CE7681509B71 ON etudiant (rfid_id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_21A5CE7681509B71 FOREIGN KEY (rfid_id) REFERENCES rfid (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP SEQUENCE etudiant_id_seq');
        $this->addSql('DROP TABLE etudiant');
    }
}
