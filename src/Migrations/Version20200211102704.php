<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211102704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE SEQUENCE promotion_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE promotion (id NUMBER(10) NOT NULL, formation_id NUMBER(10) DEFAULT NULL NULL, annee_id NUMBER(10) DEFAULT NULL NULL, annee_formation NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C11D7DD15200282E ON promotion (formation_id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD1543EC5F0 ON promotion (annee_id)');
        $this->addSql('CREATE TABLE promotion_id_etudiant (promotion_id NUMBER(10) NOT NULL, id_etudiant_id NUMBER(10) NOT NULL, PRIMARY KEY(promotion_id, id_etudiant_id))');
        $this->addSql('CREATE INDEX IDX_F05B07AC139DF194 ON promotion_id_etudiant (promotion_id)');
        $this->addSql('CREATE INDEX IDX_F05B07ACC5F87C54 ON promotion_id_etudiant (id_etudiant_id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD15200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE promotion_id_etudiant ADD CONSTRAINT FK_F05B07AC139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_id_etudiant ADD CONSTRAINT FK_F05B07ACC5F87C54 FOREIGN KEY (id_etudiant_id) REFERENCES id_etudiant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER TABLE promotion_id_etudiant DROP CONSTRAINT FK_F05B07AC139DF194');
        $this->addSql('DROP SEQUENCE promotion_id_seq');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE promotion_id_etudiant');
    }
}
