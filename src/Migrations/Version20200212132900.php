<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212132900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE annee (id INT AUTO_INCREMENT NOT NULL, debut_promotion DATE DEFAULT NULL, fin_promotion DATE DEFAULT NULL, annee_promotion INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ue (id INT AUTO_INCREMENT NOT NULL, specialite_id INT DEFAULT NULL, couleur VARCHAR(255) DEFAULT NULL, volume_horaire DOUBLE PRECISION DEFAULT NULL, nom_ue VARCHAR(255) DEFAULT NULL, INDEX IDX_2E490A9B2195E0F0 (specialite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, statut_id INT DEFAULT NULL, rfid_id INT DEFAULT NULL, specialite_id INT DEFAULT NULL, INDEX IDX_17A55299F6203804 (statut_id), UNIQUE INDEX UNIQ_17A5529981509B71 (rfid_id), INDEX IDX_17A552992195E0F0 (specialite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, ue_id INT DEFAULT NULL, salle_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, creneau INT DEFAULT NULL, is_exam TINYINT(1) DEFAULT NULL, debut DATETIME DEFAULT NULL, fin DATETIME DEFAULT NULL, is_valide TINYINT(1) DEFAULT NULL, INDEX IDX_FDCA8C9C62E883B1 (ue_id), INDEX IDX_FDCA8C9CDC304035 (salle_id), INDEX IDX_FDCA8C9CBAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, specialite VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, annee_id INT DEFAULT NULL, annee_formation INT DEFAULT NULL, INDEX IDX_C11D7DD15200282E (formation_id), INDEX IDX_C11D7DD1543EC5F0 (annee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion_etudiant (promotion_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_B72A86A7139DF194 (promotion_id), INDEX IDX_B72A86A7DDEAB1A3 (etudiant_id), PRIMARY KEY(promotion_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rfid (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, mot_de_passe VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, rfid_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_717E22E381509B71 (rfid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant_ue (etudiant_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_4C9ADC68DDEAB1A3 (etudiant_id), INDEX IDX_4C9ADC6862E883B1 (ue_id), PRIMARY KEY(etudiant_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant_cours (etudiant_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_82F0A080DDEAB1A3 (etudiant_id), INDEX IDX_82F0A0807ECF78B0 (cours_id), PRIMARY KEY(etudiant_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heures_sup (id INT AUTO_INCREMENT NOT NULL, annee_paye INT DEFAULT NULL, taux_horaire DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, capacite INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle_equipement (salle_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_D338336BDC304035 (salle_id), INDEX IDX_D338336B806F0F5C (equipement_id), PRIMARY KEY(salle_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, nom_statut VARCHAR(255) DEFAULT NULL, service_statutaire DOUBLE PRECISION DEFAULT NULL, coefficient DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, professeur_responsable_id INT DEFAULT NULL, diplome VARCHAR(255) DEFAULT NULL, nb_annee INT DEFAULT NULL, INDEX IDX_404021BF43F56ED4 (professeur_responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_cours (formation_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_8B4112E95200282E (formation_id), INDEX IDX_8B4112E97ECF78B0 (cours_id), PRIMARY KEY(formation_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_ue (formation_id INT NOT NULL, ue_id INT NOT NULL, INDEX IDX_C37045E55200282E (formation_id), INDEX IDX_C37045E562E883B1 (ue_id), PRIMARY KEY(formation_id, ue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, nom_equipement VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A5529981509B71 FOREIGN KEY (rfid_id) REFERENCES rfid (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A552992195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD15200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE promotion_etudiant ADD CONSTRAINT FK_B72A86A7139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_etudiant ADD CONSTRAINT FK_B72A86A7DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E381509B71 FOREIGN KEY (rfid_id) REFERENCES rfid (id)');
        $this->addSql('ALTER TABLE etudiant_ue ADD CONSTRAINT FK_4C9ADC68DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_ue ADD CONSTRAINT FK_4C9ADC6862E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_cours ADD CONSTRAINT FK_82F0A080DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_cours ADD CONSTRAINT FK_82F0A0807ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_equipement ADD CONSTRAINT FK_D338336BDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_equipement ADD CONSTRAINT FK_D338336B806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF43F56ED4 FOREIGN KEY (professeur_responsable_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE formation_cours ADD CONSTRAINT FK_8B4112E95200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_cours ADD CONSTRAINT FK_8B4112E97ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_ue ADD CONSTRAINT FK_C37045E55200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_ue ADD CONSTRAINT FK_C37045E562E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1543EC5F0');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C62E883B1');
        $this->addSql('ALTER TABLE etudiant_ue DROP FOREIGN KEY FK_4C9ADC6862E883B1');
        $this->addSql('ALTER TABLE formation_ue DROP FOREIGN KEY FK_C37045E562E883B1');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CBAB22EE9');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF43F56ED4');
        $this->addSql('ALTER TABLE etudiant_cours DROP FOREIGN KEY FK_82F0A0807ECF78B0');
        $this->addSql('ALTER TABLE formation_cours DROP FOREIGN KEY FK_8B4112E97ECF78B0');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B2195E0F0');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A552992195E0F0');
        $this->addSql('ALTER TABLE promotion_etudiant DROP FOREIGN KEY FK_B72A86A7139DF194');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A5529981509B71');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E381509B71');
        $this->addSql('ALTER TABLE promotion_etudiant DROP FOREIGN KEY FK_B72A86A7DDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_ue DROP FOREIGN KEY FK_4C9ADC68DDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_cours DROP FOREIGN KEY FK_82F0A080DDEAB1A3');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CDC304035');
        $this->addSql('ALTER TABLE salle_equipement DROP FOREIGN KEY FK_D338336BDC304035');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299F6203804');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD15200282E');
        $this->addSql('ALTER TABLE formation_cours DROP FOREIGN KEY FK_8B4112E95200282E');
        $this->addSql('ALTER TABLE formation_ue DROP FOREIGN KEY FK_C37045E55200282E');
        $this->addSql('ALTER TABLE salle_equipement DROP FOREIGN KEY FK_D338336B806F0F5C');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE ue');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE promotion_etudiant');
        $this->addSql('DROP TABLE rfid');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE etudiant_ue');
        $this->addSql('DROP TABLE etudiant_cours');
        $this->addSql('DROP TABLE heures_sup');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE salle_equipement');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_cours');
        $this->addSql('DROP TABLE formation_ue');
        $this->addSql('DROP TABLE equipement');
    }
}
