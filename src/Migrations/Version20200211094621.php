<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211094621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER TABLE PROFESSEUR ADD (rfid_id NUMBER(10) DEFAULT NULL NULL)');
        $this->addSql('ALTER TABLE PROFESSEUR ADD CONSTRAINT FK_17A5529981509B71 FOREIGN KEY (rfid_id) REFERENCES rfid (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17A5529981509B71 ON PROFESSEUR (rfid_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER TABLE professeur DROP CONSTRAINT FK_17A5529981509B71');
        $this->addSql('DROP INDEX UNIQ_17A5529981509B71');
        $this->addSql('ALTER TABLE professeur DROP (rfid_id)');
    }
}
