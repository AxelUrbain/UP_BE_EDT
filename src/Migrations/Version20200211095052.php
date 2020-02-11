<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211095052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE SEQUENCE cours_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE cours (id NUMBER(10) NOT NULL, ue_id NUMBER(10) DEFAULT NULL NULL, salle_id NUMBER(10) DEFAULT NULL NULL, professeur_id NUMBER(10) DEFAULT NULL NULL, creneau NUMBER(10) DEFAULT NULL NULL, is_exam NUMBER(1) DEFAULT NULL NULL, debut TIMESTAMP(0) DEFAULT NULL NULL, fin TIMESTAMP(0) DEFAULT NULL NULL, is_valide NUMBER(1) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C62E883B1 ON cours (ue_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CDC304035 ON cours (salle_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CBAB22EE9 ON cours (professeur_id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP SEQUENCE cours_id_seq');
        $this->addSql('DROP TABLE cours');
    }
}
