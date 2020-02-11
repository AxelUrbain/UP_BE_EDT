<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211103524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE TABLE id_etudiant_cours (id_etudiant_id NUMBER(10) NOT NULL, cours_id NUMBER(10) NOT NULL, PRIMARY KEY(id_etudiant_id, cours_id))');
        $this->addSql('CREATE INDEX IDX_BF961D86C5F87C54 ON id_etudiant_cours (id_etudiant_id)');
        $this->addSql('CREATE INDEX IDX_BF961D867ECF78B0 ON id_etudiant_cours (cours_id)');
        $this->addSql('ALTER TABLE id_etudiant_cours ADD CONSTRAINT FK_BF961D86C5F87C54 FOREIGN KEY (id_etudiant_id) REFERENCES id_etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE id_etudiant_cours ADD CONSTRAINT FK_BF961D867ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP TABLE id_etudiant_cours');
    }
}
