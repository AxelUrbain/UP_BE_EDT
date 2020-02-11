<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211103716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE TABLE formation_ue (formation_id NUMBER(10) NOT NULL, ue_id NUMBER(10) NOT NULL, annee NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(formation_id, ue_id))');
        $this->addSql('CREATE INDEX IDX_C37045E55200282E ON formation_ue (formation_id)');
        $this->addSql('CREATE INDEX IDX_C37045E562E883B1 ON formation_ue (ue_id)');
        $this->addSql('ALTER TABLE formation_ue ADD CONSTRAINT FK_C37045E55200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_ue ADD CONSTRAINT FK_C37045E562E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP TABLE formation_ue');
    }
}
