<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211104131 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE SEQUENCE heures_sup_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE heures_sup (id NUMBER(10) NOT NULL, annee_paye NUMBER(10) DEFAULT NULL NULL, taux_horaire DOUBLE PRECISION DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE FORMATION_UE DROP (ANNEE)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP SEQUENCE heures_sup_id_seq');
        $this->addSql('DROP TABLE heures_sup');
        $this->addSql('ALTER TABLE formation_ue ADD (ANNEE NUMBER(10) DEFAULT NULL NULL)');
    }
}
