<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211142346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER INDEX uniq_21a5ce7681509b71 RENAME TO UNIQ_717E22E381509B71');
        $this->addSql('ALTER INDEX idx_5488119fc5f87c54 RENAME TO IDX_4C9ADC68DDEAB1A3');
        $this->addSql('ALTER INDEX idx_5488119f62e883b1 RENAME TO IDX_4C9ADC6862E883B1');
        $this->addSql('ALTER INDEX idx_bf961d86c5f87c54 RENAME TO IDX_82F0A080DDEAB1A3');
        $this->addSql('ALTER INDEX idx_bf961d867ecf78b0 RENAME TO IDX_82F0A0807ECF78B0');
        $this->addSql('ALTER INDEX idx_f05b07ac139df194 RENAME TO IDX_B72A86A7139DF194');
        $this->addSql('ALTER INDEX idx_f05b07acc5f87c54 RENAME TO IDX_B72A86A7DDEAB1A3');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER INDEX uniq_717e22e381509b71 RENAME TO uniq_21a5ce7681509b71');
        $this->addSql('ALTER INDEX idx_b72a86a7ddeab1a3 RENAME TO idx_f05b07acc5f87c54');
        $this->addSql('ALTER INDEX idx_b72a86a7139df194 RENAME TO idx_f05b07ac139df194');
        $this->addSql('ALTER INDEX idx_4c9adc6862e883b1 RENAME TO idx_5488119f62e883b1');
        $this->addSql('ALTER INDEX idx_4c9adc68ddeab1a3 RENAME TO idx_5488119fc5f87c54');
        $this->addSql('ALTER INDEX idx_82f0a0807ecf78b0 RENAME TO idx_bf961d867ecf78b0');
        $this->addSql('ALTER INDEX idx_82f0a080ddeab1a3 RENAME TO idx_bf961d86c5f87c54');
    }
}
