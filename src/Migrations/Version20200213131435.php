<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213131435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE SEQUENCE annee_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE cours_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE equipement_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE etudiant_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE formation_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE formation_ue_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE heures_sup_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE professeur_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE promotion_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE rfid_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE salle_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE specialite_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE statut_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE ue_id_seq START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE annee (id NUMBER(10) NOT NULL, debut_promotion DATE DEFAULT NULL NULL, fin_promotion DATE DEFAULT NULL NULL, annee_promotion NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cours (id NUMBER(10) NOT NULL, ue_id NUMBER(10) DEFAULT NULL NULL, salle_id NUMBER(10) DEFAULT NULL NULL, professeur_id NUMBER(10) DEFAULT NULL NULL, creneau NUMBER(10) DEFAULT NULL NULL, is_exam NUMBER(1) DEFAULT NULL NULL, debut TIMESTAMP(0) DEFAULT NULL NULL, fin TIMESTAMP(0) DEFAULT NULL NULL, is_valide NUMBER(1) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C62E883B1 ON cours (ue_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CDC304035 ON cours (salle_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CBAB22EE9 ON cours (professeur_id)');
        $this->addSql('CREATE TABLE equipement (id NUMBER(10) NOT NULL, nom_equipement VARCHAR2(255) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE etudiant (id NUMBER(10) NOT NULL, rfid_id NUMBER(10) DEFAULT NULL NULL, promotion_id NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E381509B71 ON etudiant (rfid_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3139DF194 ON etudiant (promotion_id)');
        $this->addSql('CREATE TABLE etudiant_ue (etudiant_id NUMBER(10) NOT NULL, ue_id NUMBER(10) NOT NULL, PRIMARY KEY(etudiant_id, ue_id))');
        $this->addSql('CREATE INDEX IDX_4C9ADC68DDEAB1A3 ON etudiant_ue (etudiant_id)');
        $this->addSql('CREATE INDEX IDX_4C9ADC6862E883B1 ON etudiant_ue (ue_id)');
        $this->addSql('CREATE TABLE etudiant_cours (etudiant_id NUMBER(10) NOT NULL, cours_id NUMBER(10) NOT NULL, PRIMARY KEY(etudiant_id, cours_id))');
        $this->addSql('CREATE INDEX IDX_82F0A080DDEAB1A3 ON etudiant_cours (etudiant_id)');
        $this->addSql('CREATE INDEX IDX_82F0A0807ECF78B0 ON etudiant_cours (cours_id)');
        $this->addSql('CREATE TABLE formation (id NUMBER(10) NOT NULL, professeur_responsable_id NUMBER(10) DEFAULT NULL NULL, diplome VARCHAR2(255) DEFAULT NULL NULL, nb_annee NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_404021BF43F56ED4 ON formation (professeur_responsable_id)');
        $this->addSql('CREATE TABLE formation_cours (formation_id NUMBER(10) NOT NULL, cours_id NUMBER(10) NOT NULL, PRIMARY KEY(formation_id, cours_id))');
        $this->addSql('CREATE INDEX IDX_8B4112E95200282E ON formation_cours (formation_id)');
        $this->addSql('CREATE INDEX IDX_8B4112E97ECF78B0 ON formation_cours (cours_id)');
        $this->addSql('CREATE TABLE formation_ue (id NUMBER(10) NOT NULL, formation_id NUMBER(10) DEFAULT NULL NULL, ue_id NUMBER(10) DEFAULT NULL NULL, annee_formation NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C37045E55200282E ON formation_ue (formation_id)');
        $this->addSql('CREATE INDEX IDX_C37045E562E883B1 ON formation_ue (ue_id)');
        $this->addSql('CREATE TABLE heures_sup (id NUMBER(10) NOT NULL, annee_paye NUMBER(10) DEFAULT NULL NULL, taux_horaire DOUBLE PRECISION DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE professeur (id NUMBER(10) NOT NULL, statut_id NUMBER(10) DEFAULT NULL NULL, rfid_id NUMBER(10) DEFAULT NULL NULL, specialite_id NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_17A55299F6203804 ON professeur (statut_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17A5529981509B71 ON professeur (rfid_id)');
        $this->addSql('CREATE INDEX IDX_17A552992195E0F0 ON professeur (specialite_id)');
        $this->addSql('CREATE TABLE promotion (id NUMBER(10) NOT NULL, formation_id NUMBER(10) DEFAULT NULL NULL, annee_id NUMBER(10) DEFAULT NULL NULL, annee_formation NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C11D7DD15200282E ON promotion (formation_id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD1543EC5F0 ON promotion (annee_id)');
        $this->addSql('CREATE TABLE rfid (id NUMBER(10) NOT NULL, nom VARCHAR2(255) DEFAULT NULL NULL, prenom VARCHAR2(255) DEFAULT NULL NULL, roles CLOB NOT NULL, mot_de_passe VARCHAR2(255) DEFAULT NULL NULL, username VARCHAR2(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN rfid.roles IS \'(DC2Type:json)\'');
        $this->addSql('CREATE TABLE salle (id NUMBER(10) NOT NULL, nom VARCHAR2(255) DEFAULT NULL NULL, capacite NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE salle_equipement (salle_id NUMBER(10) NOT NULL, equipement_id NUMBER(10) NOT NULL, PRIMARY KEY(salle_id, equipement_id))');
        $this->addSql('CREATE INDEX IDX_D338336BDC304035 ON salle_equipement (salle_id)');
        $this->addSql('CREATE INDEX IDX_D338336B806F0F5C ON salle_equipement (equipement_id)');
        $this->addSql('CREATE TABLE specialite (id NUMBER(10) NOT NULL, specialite VARCHAR2(255) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE statut (id NUMBER(10) NOT NULL, nom_statut VARCHAR2(255) DEFAULT NULL NULL, service_statutaire DOUBLE PRECISION DEFAULT NULL NULL, coefficient DOUBLE PRECISION DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ue (id NUMBER(10) NOT NULL, specialite_id NUMBER(10) DEFAULT NULL NULL, couleur VARCHAR2(255) DEFAULT NULL NULL, volume_horaire DOUBLE PRECISION DEFAULT NULL NULL, nom_ue VARCHAR2(255) DEFAULT NULL NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2E490A9B2195E0F0 ON ue (specialite_id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E381509B71 FOREIGN KEY (rfid_id) REFERENCES rfid (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE etudiant_ue ADD CONSTRAINT FK_4C9ADC68DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_ue ADD CONSTRAINT FK_4C9ADC6862E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_cours ADD CONSTRAINT FK_82F0A080DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_cours ADD CONSTRAINT FK_82F0A0807ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF43F56ED4 FOREIGN KEY (professeur_responsable_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE formation_cours ADD CONSTRAINT FK_8B4112E95200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_cours ADD CONSTRAINT FK_8B4112E97ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_ue ADD CONSTRAINT FK_C37045E55200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE formation_ue ADD CONSTRAINT FK_C37045E562E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A5529981509B71 FOREIGN KEY (rfid_id) REFERENCES rfid (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A552992195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD15200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE salle_equipement ADD CONSTRAINT FK_D338336BDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_equipement ADD CONSTRAINT FK_D338336B806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('ALTER TABLE promotion DROP CONSTRAINT FK_C11D7DD1543EC5F0');
        $this->addSql('ALTER TABLE etudiant_cours DROP CONSTRAINT FK_82F0A0807ECF78B0');
        $this->addSql('ALTER TABLE formation_cours DROP CONSTRAINT FK_8B4112E97ECF78B0');
        $this->addSql('ALTER TABLE salle_equipement DROP CONSTRAINT FK_D338336B806F0F5C');
        $this->addSql('ALTER TABLE etudiant_ue DROP CONSTRAINT FK_4C9ADC68DDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_cours DROP CONSTRAINT FK_82F0A080DDEAB1A3');
        $this->addSql('ALTER TABLE formation_cours DROP CONSTRAINT FK_8B4112E95200282E');
        $this->addSql('ALTER TABLE formation_ue DROP CONSTRAINT FK_C37045E55200282E');
        $this->addSql('ALTER TABLE promotion DROP CONSTRAINT FK_C11D7DD15200282E');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9CBAB22EE9');
        $this->addSql('ALTER TABLE formation DROP CONSTRAINT FK_404021BF43F56ED4');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT FK_717E22E3139DF194');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT FK_717E22E381509B71');
        $this->addSql('ALTER TABLE professeur DROP CONSTRAINT FK_17A5529981509B71');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9CDC304035');
        $this->addSql('ALTER TABLE salle_equipement DROP CONSTRAINT FK_D338336BDC304035');
        $this->addSql('ALTER TABLE professeur DROP CONSTRAINT FK_17A552992195E0F0');
        $this->addSql('ALTER TABLE ue DROP CONSTRAINT FK_2E490A9B2195E0F0');
        $this->addSql('ALTER TABLE professeur DROP CONSTRAINT FK_17A55299F6203804');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9C62E883B1');
        $this->addSql('ALTER TABLE etudiant_ue DROP CONSTRAINT FK_4C9ADC6862E883B1');
        $this->addSql('ALTER TABLE formation_ue DROP CONSTRAINT FK_C37045E562E883B1');
        $this->addSql('DROP SEQUENCE annee_id_seq');
        $this->addSql('DROP SEQUENCE cours_id_seq');
        $this->addSql('DROP SEQUENCE equipement_id_seq');
        $this->addSql('DROP SEQUENCE etudiant_id_seq');
        $this->addSql('DROP SEQUENCE formation_id_seq');
        $this->addSql('DROP SEQUENCE formation_ue_id_seq');
        $this->addSql('DROP SEQUENCE heures_sup_id_seq');
        $this->addSql('DROP SEQUENCE professeur_id_seq');
        $this->addSql('DROP SEQUENCE promotion_id_seq');
        $this->addSql('DROP SEQUENCE rfid_id_seq');
        $this->addSql('DROP SEQUENCE salle_id_seq');
        $this->addSql('DROP SEQUENCE specialite_id_seq');
        $this->addSql('DROP SEQUENCE statut_id_seq');
        $this->addSql('DROP SEQUENCE ue_id_seq');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE etudiant_ue');
        $this->addSql('DROP TABLE etudiant_cours');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_cours');
        $this->addSql('DROP TABLE formation_ue');
        $this->addSql('DROP TABLE heures_sup');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE rfid');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE salle_equipement');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE ue');
    }
}
