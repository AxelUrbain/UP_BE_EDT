<?php

namespace App\DataFixtures;

use App\Entity\Annee;
use App\Entity\Cours;
use App\Entity\Equipement;
use App\Entity\Etudiant;
use App\Entity\Fonction;
use App\Entity\Formation;
use App\Entity\Professeur;
use App\Entity\Promotion;
use App\Entity\RFID;
use App\Entity\Salle;
use App\Entity\Specialite;
use App\Entity\Statut;
use App\Entity\UE;
use App\Entity\FormationUE;
use App\Repository\FonctionRepository;
use App\Repository\ProfesseurRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $year = 2015;

        // ANNEE
        for ($i = 0; $i < 10; $i++) {
            $annee = new Annee();
            $annee->setAnneePromotion($year + $i);
            $annee->setDebutPromotion(new DateTime(($year + $i) . '-09-09'));
            $annee->setFinPromotion(new DateTime(($year + ($i + 1)) . '-09-09'));
            $manager->persist($annee);
        }
        $manager->flush();

        $types = ['maître de conférences', 'chargé de TD', 'professeur d\'université'];
        $services = [250, 192, 234];
        $coeff = [0.3, 0.75, 0.86];

        //STATUTS
        for ($i = 0; $i < 3; $i++) {
            $status = new Statut();
            $status->setNomStatut($types[$i]);
            $status->setServiceStatutaire($services[$i]);
            $status->setCoefficient($coeff[$i]);
            $manager->persist($status);
        }
        $manager->flush();

        // SPECIALITES
        $specialites = ['biophysique', 'génie moléculaire', 'physique quantique', 'sociologie', 'psychologie', 'Lettres modernes', 'Latin', 'Grec', 'géologie', 'droit'];
        for ($i = 0; $i < sizeof($specialites); $i++) {
            $spe = new Specialite();
            $spe->setSpecialite($specialites[$i]);
            $manager->persist($spe);
        }
        $manager->flush();

        // EQUIPEMENTS
        $equ = ['télévision', 'retroprojecteur', 'modulateur quantique', 'boîte à meuhs', 'régulateur thermique'];
        for ($i = 0; $i < sizeof($equ); $i++) {
            $e = new Equipement();
            $e->setNomEquipement($equ[$i]);
            $manager->persist($e);
        }
        $manager->flush();

        // SALLES
        for ($i = 0; $i < 150; $i++) {
            $salle = new Salle();
            $salle->setNom(300 + $i);
            $random = rand(0, 100);
            if ($random <= 12) {
                $equipement = $this->em->getRepository(Equipement::class)->findOneBy(['nomEquipement' => 'télévision']);
                $salle->addEquipement($equipement);
            }
            if ($random > 12 && $random <= 33) {
                $equipement = $this->em->getRepository(Equipement::class)->findOneBy(['nomEquipement' => 'retroprojecteur']);
                $salle->addEquipement($equipement);
            }
            if ($random > 33 && $random <= 50) {
                $equipement = $this->em->getRepository(Equipement::class)->findOneBy(['nomEquipement' => 'boîte à meuhs']);
                $salle->addEquipement($equipement);
            }
            if ($random > 50 && $random <= 75) {
                $equipement = $this->em->getRepository(Equipement::class)->findOneBy(['nomEquipement' => 'régulateur thermique']);
                $salle->addEquipement($equipement);
            }
            $salle->setCapacite($faker->numberBetween(15, 30));
            $manager->persist($salle);
        }
        $manager->flush();

        // RFIDs ADMIN
        $admin = new RFID();
        $admin->setUsername('admin');
        $admin->setNom('admin');
        $admin->setPrenom('admin');
        $admin->setMotDePasse('$argon2id$v=19$m=65536,t=4,p=1$0TzLvwFlAKPNE0lP8QfcoA$Y+KaDA+YXApgi1JjOWYZmGbCI5w9ZyPRXggOl87I7xw');
        $admin->setRoles( ['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();

        // RFIDs Scolarité
        $sco = new RFID();
        $sco->setUsername('sco');
        $sco->setNom('sco');
        $sco->setPrenom('sco');
        $sco->setMotDePasse('$argon2id$v=19$m=65536,t=4,p=1$0TzLvwFlAKPNE0lP8QfcoA$Y+KaDA+YXApgi1JjOWYZmGbCI5w9ZyPRXggOl87I7xw');
        $sco->setRoles(['ROLE_SECRETARIAT']);
        $manager->persist($sco);
        $manager->flush();

        // RFIDs RH
        $sec = new RFID();
        $sec->setUsername('RH');
        $sec->setNom('RH');
        $sec->setPrenom('RH');
        $sec->setMotDePasse('$argon2id$v=19$m=65536,t=4,p=1$0TzLvwFlAKPNE0lP8QfcoA$Y+KaDA+YXApgi1JjOWYZmGbCI5w9ZyPRXggOl87I7xw');
        $sec->setRoles(['ROLE_RH']);
        $manager->persist($sec);
        $manager->flush();


        // Statuts
        $types = ['maître de conférences', 'chargé de TD', 'professeur d\'université'];
        $array = [];

        $statut1 = $this->em->getRepository(Statut::class)->findOneBy(['nomStatut' => $types[0]]);
        $statut2 = $this->em->getRepository(Statut::class)->findOneBy(['nomStatut' => $types[1]]);
        $statut3 = $this->em->getRepository(Statut::class)->findOneBy(['nomStatut' => $types[2]]);

        $array[] = $statut1;
        $array[] = $statut2;
        $array[] = $statut3;

        $specialites = ['biophysique', 'génie moléculaire', 'physique quantique', 'sociologie', 'psychologie', 'Lettres modernes', 'Latin', 'Grec', 'géologie', 'droit'];
        $array2 = [];

        $spe1 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[0]]);
        $spe2 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[1]]);
        $spe3 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[2]]);
        $spe4 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[3]]);
        $spe5 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[4]]);
        $spe6 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[5]]);
        $spe7 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[6]]);
        $spe8 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[7]]);
        $spe9 = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $specialites[8]]);

        $array2[] = $spe1;
        $array2[] = $spe2;
        $array2[] = $spe3;
        $array2[] = $spe4;
        $array2[] = $spe5;
        $array2[] = $spe6;
        $array2[] = $spe7;
        $array2[] = $spe8;
        $array2[] = $spe9;


        // PROFs
        for ($i = 0; $i < 60; $i++) {
            $rfid = new RFID();
            $rfid->setUsername($faker->userName);
            $rfid->setNom($faker->lastName);
            $rfid->setPrenom($faker->firstName);
            $rfid->setMotDePasse('$argon2id$v=19$m=65536,t=4,p=1$0TzLvwFlAKPNE0lP8QfcoA$Y+KaDA+YXApgi1JjOWYZmGbCI5w9ZyPRXggOl87I7xw');
            $manager->persist($rfid);

            $prof = new Professeur();
            $prof->setRFID($rfid);
            $prof->setSpecialite($array2[rand(0, sizeof($array2) - 1)]);
            $prof->setStatut($array[rand(0, sizeof($array) - 1)]);
            $manager->persist($prof);
        }
        $manager->flush();

        // ETUDIANTS
        for ($i = 0; $i < 1500; $i++) {
            $rfid = new RFID();
            $rfid->setUsername($faker->userName);
            $rfid->setNom($faker->lastName);
            $rfid->setPrenom($faker->firstName);
            $rfid->setMotDePasse('$argon2id$v=19$m=65536,t=4,p=1$0TzLvwFlAKPNE0lP8QfcoA$Y+KaDA+YXApgi1JjOWYZmGbCI5w9ZyPRXggOl87I7xw');
            $rfid->setRoles(['ROLE_ETU']);
            $manager->persist($rfid);
            $etudiant = new Etudiant();
            $etudiant->setRFID($rfid);
            $manager->persist($etudiant);
        }
        $manager->flush();

        // UEs
        $spes = ['biophysique', 'génie moléculaire', 'physique quantique', 'sociologie', 'psychologie', 'Lettres modernes', 'Latin', 'Grec', 'géologie', 'droit'];
        $array = [];
        for ($i = 0; $i < sizeof($spes); $i++) {
            $array[$i] = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $spes[$i]]);
        };

        for ($i = 0; $i < 150; $i++) {
            $ue = new UE();
            $ue->setNomUE($array[rand(0, sizeof($array) - 1)]->getSpecialite() . ' UE-' . $i);
            $ue->setCouleur($faker->colorName);
            $ue->setVolumeHoraire($faker->numberBetween(50, 150));
            $ue->setSpecialite($array[rand(0, sizeof($array) - 1)]);
            $manager->persist($ue);
        }
        $manager->flush();

        // COURS
        $creneau = 1;
        for($i = 0; $i < 1200; $i++) {
            $cours = new Cours();
            $cours->setCreneau(rand(1,600));

            if(rand(0,3) <= 2) {
                $cours = new Cours();
                $cours->setCreneau($creneau);

                $random = rand(0,100);
                if ($random > 50) $cours->setIsValide(true);
                else $cours->setIsValide(false);

                //Ajout cours
                $spe = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $spes[rand(0, sizeof($spes) - 1)]]);
                $ue = $this->em->getRepository(UE::class)->findOneBy(['specialite' => $spe->getId()]);
                $cours->setUE($ue);

                //Ajout salle
                $salle = $this->em->getRepository(Salle::class)->findOneBy(['nom' => rand(300, 449)]);
                $cours->setSalle($salle);

                //Ajout prof
                $prof = $this->em->getRepository(Professeur::class)->findByRandomValue();
                $cours->setProfesseur($prof);

                $manager->persist($cours);
            }

            $creneau++;
        }
        $manager->flush();

        $diplomes = ['Licence', 'Master', 'Licence professionelle', 'Doctorat'];

        // Formation
        for ($i = 0; $i < 50; $i++) {
            $formation = new Formation();
            $dip = $diplomes[rand(0, sizeof($diplomes) - 1)];
            $formation->setDiplome($dip);
            switch ($dip) {
                case 'Licence':
                    $formation->setNbAnnee(3);
                    break;
                case 'Master':
                    $formation->setNbAnnee(2);
                    break;
                case 'Licence professionelle':
                    $formation->setNbAnnee(1);
                    break;
                case 'Doctorat':
                    $formation->setNbAnnee(2);
                    break;
            }
            $prof = $this->em->getRepository(Professeur::class)->findByRandomValue();
            $rfid = $this->em->getRepository(RFID::class)->findOneBy(['id' => $prof->getRFID()]);
            $rfid->setRoles(['ROLE_RESPONSABLE']);
            $formation->setProfesseurResponsable($prof);
            $manager->persist($rfid);
            $manager->persist($formation);
        }
        $manager->flush();

        // Formation UE
        $formations = $this->em->getRepository(Formation::class)->findAll();
        foreach($formations as $formation) {
            $randUe = rand(0,5);
            for($i = 0; $i < $randUe; $i++) {
                $formationUE = new FormationUE();
                $ue = $this->em->getRepository(UE::class)->findByRandomValue();
                $formationUE->setUe($ue);
                $formationUE->setAnneeFormation(rand(1,$formation->getNbAnnee()));
                $formation->addFormationUE($formationUE);
                $manager->persist($formationUE);
            }
        }
        $manager->flush();

        // Promotion
        foreach($formations as $formation) {
            $promotion = new Promotion();
            $promotion->setAnneeFormation(rand(1, $formation->getNbAnnee()));
            $promotion->setFormation($formation);
            $promotion->setAnnee($this->em->getRepository(Annee::class)->findByRandomValue());
            $randEtudiant = rand(0,30);
            for($i = 0; $i < $randEtudiant; $i++) {
                $promotion->addEtudiant($this->em->getRepository(Etudiant::class)->findByRandomValue());
            }
            $manager->persist($promotion);
        }
        $manager->flush();
    }
}
