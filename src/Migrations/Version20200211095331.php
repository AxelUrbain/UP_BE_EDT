<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211095331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER TABLE PROFESSEUR ADD (specialite_id NUMBER(10) DEFAULT NULL NULL)');
        $this->addSql('ALTER TABLE PROFESSEUR ADD CONSTRAINT FK_17A552992195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('CREATE INDEX IDX_17A552992195E0F0 ON PROFESSEUR (specialite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER TABLE professeur DROP CONSTRAINT FK_17A552992195E0F0');
        $this->addSql('DROP INDEX IDX_17A552992195E0F0');
        $this->addSql('ALTER TABLE professeur DROP (specialite_id)');
    }
}
