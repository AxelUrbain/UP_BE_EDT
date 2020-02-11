<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211093242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE TABLE rfid_fonction (rfid_id NUMBER(10) NOT NULL, fonction_id NUMBER(10) NOT NULL, PRIMARY KEY(rfid_id, fonction_id))');
        $this->addSql('CREATE INDEX IDX_20EFCE6181509B71 ON rfid_fonction (rfid_id)');
        $this->addSql('CREATE INDEX IDX_20EFCE6157889920 ON rfid_fonction (fonction_id)');
        $this->addSql('ALTER TABLE rfid_fonction ADD CONSTRAINT FK_20EFCE6181509B71 FOREIGN KEY (rfid_id) REFERENCES rfid (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rfid_fonction ADD CONSTRAINT FK_20EFCE6157889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP TABLE rfid_fonction');
    }
}
