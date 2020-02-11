<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211094016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE SEQUENCE professeur_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE professeur (id NUMBER(10) NOT NULL, statut_id NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_17A55299F6203804 ON professeur (statut_id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP SEQUENCE professeur_id_seq');
        $this->addSql('DROP TABLE professeur');
    }
}
