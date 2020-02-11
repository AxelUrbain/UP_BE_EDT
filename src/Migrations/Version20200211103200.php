<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211103200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE TABLE etudiant_ue (etudiant_id NUMBER(10) NOT NULL, ue_id NUMBER(10) NOT NULL, PRIMARY KEY(etudiant_id, ue_id))');
        $this->addSql('CREATE INDEX IDX_5488119FC5F87C54 ON etudiant_ue (etudiant_id)');
        $this->addSql('CREATE INDEX IDX_5488119F62E883B1 ON etudiant_ue (ue_id)');
        $this->addSql('ALTER TABLE etudiant_ue ADD CONSTRAINT FK_5488119FC5F87C54 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_ue ADD CONSTRAINT FK_5488119F62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP TABLE etudiant_ue');
    }
}
