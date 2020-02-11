<?php

namespace App\DataFixtures;

use App\Entity\Annee;
use App\Entity\Equipement;
use App\Entity\Fonction;
use App\Entity\RFID;
use App\Entity\Salle;
use App\Entity\Specialite;
use App\Entity\Statut;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $year = 2015;
        for ($i = 0 ; $i < 10; $i++) {
            $annee = new Annee();
            $annee->setAnneePromotion($year + $i);
            $annee->setDebutPromotion(new DateTime( ($year + $i) .'-09-09'));
            $annee->setFinPromotion(new DateTime( ($year + ($i + 1)) .'-09-09'));
            $manager->persist($annee);
        }
        $manager->flush();


        $types = ['maître de conférences', 'chargé de TD', 'professeur d\'université'];
        $services = [250, 192, 234];
        $coeff = [0.3, 0.75, 0.86];

        for ($i = 0; $i < 3; $i++) {
            $status = new Statut();
            $status->setNomStatut($types[$i]);
            $status->setServiceStatutaire($services[$i]);
            $status->setCoefficient($coeff[$i]);
            $manager->persist($status);
        }
        $manager->flush();

        $specialites = ['biophysique', 'génie moléculaire', 'physique quantique', 'sociologie', 'psychologie', 'Lettres modernes', 'Latin', 'Grec', 'géologie', 'droit'];
        for ($i = 0; $i < sizeof($specialites); $i++) {
            $spe = new Specialite();
            $spe->setSpecialite($specialites[$i]);
            $manager->persist($spe);
        }
        $manager->flush();

        $equ = ['télévision', 'retroprojecteur', 'modulateur quantique', 'boîte à meuhs', 'régulateur thermique'];
        for ($i = 0; $i < sizeof($equ); $i++) {
            $e = new Equipement();
            $e->setNomEquipement($equ[$i]);
            $manager->persist($e);
        }
        $manager->flush();

        $salle = 300;
        for ($i = 0; $i < 150; $i++) {
            $salle = new Salle();
            $salle->setIdSalle(300 + $i);
            $salle->setCapacite($faker->numberBetween(15,30));
            $manager->persist($salle);
        }
        $manager->flush();

        for ($i = 0; $i < 500; $i++) {
        $rfid = new RFID();
        $rfid->setNom($faker->lastName);
        $rfid->setPrenom($faker->firstName);
        $rfid->setPassword('admin');
        $manager->persist($rfid);
        }
        $manager->flush();

        $foncs = ['étudiant', 'professeur', 'administrateur', 'scolarité', 'secrétariat'];
        for ($i = 0; $i < sizeof($foncs); $i++) {
            $fonctions = new Fonction();
            $fonctions->setNomFonction($foncs[$i]);
            $manager->persist($fonctions);
        }
        $manager->flush();
    }
}
