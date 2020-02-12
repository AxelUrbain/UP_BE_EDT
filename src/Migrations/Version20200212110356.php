<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212110356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER TABLE ETUDIANT ADD (promotion_id NUMBER(10) DEFAULT NULL NULL)');
        $this->addSql('ALTER TABLE ETUDIANT ADD CONSTRAINT FK_717E22E3139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3139DF194 ON ETUDIANT (promotion_id)');
        $this->addSql('ALTER INDEX uniq_21a5ce7681509b71 RENAME TO UNIQ_717E22E381509B71');
        $this->addSql('ALTER INDEX idx_5488119fc5f87c54 RENAME TO IDX_4C9ADC68DDEAB1A3');
        $this->addSql('ALTER INDEX idx_5488119f62e883b1 RENAME TO IDX_4C9ADC6862E883B1');
        $this->addSql('ALTER INDEX idx_bf961d86c5f87c54 RENAME TO IDX_82F0A080DDEAB1A3');
        $this->addSql('ALTER INDEX idx_bf961d867ecf78b0 RENAME TO IDX_82F0A0807ECF78B0');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE TABLE PROMOTION_ETUDIANT (PROMOTION_ID NUMBER(10) NOT NULL, ETUDIANT_ID NUMBER(10) NOT NULL, PRIMARY KEY(PROMOTION_ID, ETUDIANT_ID))');
        $this->addSql('CREATE INDEX idx_f05b07acc5f87c54 ON PROMOTION_ETUDIANT (ETUDIANT_ID)');
        $this->addSql('CREATE INDEX idx_f05b07ac139df194 ON PROMOTION_ETUDIANT (PROMOTION_ID)');
        $this->addSql('ALTER TABLE PROMOTION_ETUDIANT ADD CONSTRAINT FK_F05B07ACC5F87C54 FOREIGN KEY (ETUDIANT_ID) REFERENCES ETUDIANT (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE PROMOTION_ETUDIANT ADD CONSTRAINT FK_F05B07AC139DF194 FOREIGN KEY (PROMOTION_ID) REFERENCES PROMOTION (ID) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rfid MODIFY (ROLES VARCHAR2(255) DEFAULT NULL NULL)');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT FK_717E22E3139DF194');
        $this->addSql('DROP INDEX IDX_717E22E3139DF194');
        $this->addSql('ALTER TABLE etudiant DROP (promotion_id)');
        $this->addSql('ALTER INDEX uniq_717e22e381509b71 RENAME TO uniq_21a5ce7681509b71');
        $this->addSql('ALTER INDEX idx_4c9adc6862e883b1 RENAME TO idx_5488119f62e883b1');
        $this->addSql('ALTER INDEX idx_4c9adc68ddeab1a3 RENAME TO idx_5488119fc5f87c54');
        $this->addSql('ALTER INDEX idx_82f0a0807ecf78b0 RENAME TO idx_bf961d867ecf78b0');
        $this->addSql('ALTER INDEX idx_82f0a080ddeab1a3 RENAME TO idx_bf961d86c5f87c54');
        $this->addSql('ALTER TABLE formation_ue ADD (ANNEE NUMBER(10) DEFAULT NULL NULL)');
    }
}
