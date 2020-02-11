<?php

namespace App\DataFixtures;

use App\Entity\Annee;
use App\Entity\Equipement;
use App\Entity\Fonction;
use App\Entity\Professeur;
use App\Entity\RFID;
use App\Entity\Salle;
use App\Entity\Specialite;
use App\Entity\Statut;
use App\Entity\UE;
use App\Repository\FonctionRepository;
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
            $salle->setNom('ha');
            $random = rand(0,100);
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

        // FONCTIONS(ROLES)
        $foncs = ['étudiant', 'professeur', 'administrateur', 'scolarité', 'secrétariat'];
        for ($i = 0; $i < sizeof($foncs); $i++) {
            $fonctions = new Fonction();
            $fonctions->setNomFonction($foncs[$i]);
            $manager->persist($fonctions);
        }
        $manager->flush();

        // RFIDs ADMIN
        $admin = new RFID();
        $admin->setNom('admin');
        $admin->setPrenom('admin');
        $admin->setMotDePasse('admin');
        $fonction = $this->em->getRepository(Fonction::class)->findOneBy(['nomFonction' => 'administrateur']);
        $admin->addFonction($fonction);
        $manager->persist($admin);
        $manager->flush();

        // RFIDs Scolarité
        $sco = new RFID();
        $sco->setNom('sco');
        $sco->setPrenom('sco');
        $sco->setMotDePasse('admin');
        $fonction2 = $this->em->getRepository(Fonction::class)->findOneBy(['nomFonction' => 'scolarité']);
        $sco->addFonction($fonction2);
        $manager->persist($sco);
        $manager->flush();

        // RFIDs Sécrétariat
        $sec = new RFID();
        $sec->setNom('sec');
        $sec->setPrenom('sec');
        $sec->setMotDePasse('admin');
        $fonction3 = $this->em->getRepository(Fonction::class)->findOneBy(['nomFonction' => 'secrétariat']);
        $sec->addFonction($fonction3);
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


        // PROFs
        for ($i = 0; $i < 60; $i++) {
            $rfid = new RFID();
            $rfid->setNom($faker->lastName);
            $rfid->setPrenom($faker->firstName);
            $fonction4 = $this->em->getRepository(Fonction::class)->findOneBy(['nomFonction' => 'professeur']);
            $rfid->addFonction($fonction4);
            $rfid->setMotDePasse('admin');
            $manager->persist($rfid);

            $prof = new Professeur();
            $prof->setRFID($rfid);
            $prof->setStatut($array[rand(0, sizeof($array) - 1)]);
            $manager->persist($prof);
        }
        $manager->flush();

        // ETUDIANTS
        for ($i = 0; $i < 1500; $i++) {
            $rfid = new RFID();
            $rfid->setNom($faker->lastName);
            $rfid->setPrenom($faker->firstName);
            $rfid->setMotDePasse('admin');
            $fonction5 = $this->em->getRepository(Fonction::class)->findOneBy(['nomFonction' => 'étudiant']);
            $rfid->addFonction($fonction5);
            $manager->persist($rfid);
        }
        $manager->flush();

        // UEs
        $spes = ['biophysique', 'génie moléculaire', 'physique quantique', 'sociologie', 'psychologie', 'Lettres modernes', 'Latin', 'Grec', 'géologie', 'droit'];
        $array = [];
        for ($i = 0 ; $i < sizeof($spes); $i++) {
            $array[$i] = $this->em->getRepository(Specialite::class)->findOneBy(['specialite' => $spes[$i]]);
        };

        for ($i = 0; $i < 1500; $i++) {
            $ue = new UE();
            $ue->setNomUE($faker->word . ' ' . $faker->word . ' ' . $faker->word );
            $ue->setCouleur($faker->colorName);
            $ue->setVolumeHoraire($faker->numberBetween(50,150));
            $ue->setSpecialite($array[rand(0, sizeof($array) - 1)]);
            $manager->persist($ue);
        }
        $manager->flush();
    }
}
