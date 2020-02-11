<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200110203134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE equipments_classroom (equipments_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_A16C784EBD251DD7 (equipments_id), INDEX IDX_A16C784E6278D5A8 (classroom_id), PRIMARY KEY(equipments_id, classroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipments_classroom ADD CONSTRAINT FK_A16C784EBD251DD7 FOREIGN KEY (equipments_id) REFERENCES equipments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipments_classroom ADD CONSTRAINT FK_A16C784E6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipments DROP FOREIGN KEY FK_6F6C25446278D5A8');
        $this->addSql('DROP INDEX IDX_6F6C25446278D5A8 ON equipments');
        $this->addSql('ALTER TABLE equipments DROP classroom_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE equipments_classroom');
        $this->addSql('ALTER TABLE equipments ADD classroom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipments ADD CONSTRAINT FK_6F6C25446278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id)');
        $this->addSql('CREATE INDEX IDX_6F6C25446278D5A8 ON equipments (classroom_id)');
    }
}
