<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Professeur;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/planning")
 */
class PlanningController extends AbstractController
{
    /**
     * @Route("/ajouter/{creneau}", name="ajouter_seance", methods={"GET","POST"})
     */
    public function ajouterSeance(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, $creneau = -1)
    {
        if ($creneau < 1) {
            return $this->redirectToRoute('afficher_planning');
        }
        $cours = new Cours();

        $form = $this->createForm(CoursType::class, $cours);
        $form->add('sauvegarder', SubmitType::class, ['label' => 'Ajouter']);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $specialite = $cours->getUE()->getSpecialite()->getId();
            $professeur = $em->getRepository('App\Entity\Professeur')->findProfesseurLibre((int) $creneau, $specialite);
            $salle = $em->getRepository('App\Entity\Salle')->findSalleLibre((int) $cours->getCreneau());

            $cours->setCreneau($creneau);
            $cours->setProfesseur($professeur);
            $cours->setSalle($salle);
            $cours->setIsValide(1);

            $errors = $validator->validate($cours);

            if (count($errors) == 0) {
                $em->persist($cours);
                $em->flush();
            } else {
                foreach ($errors as $error) {
                    $this->addFlash('danger', $error->getMessage());
                }
            }

            return $this->redirectToRoute('afficher_planning');
        }

        return $this->render('planning/_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editer/{id}",
     *     name="editer_seance",
     *     methods={"GET","POST"},
     *     requirements={"id": "\d+"}
     * )
     */
    public function editerSeance(Request $request, EntityManagerInterface $em, $id = -1)
    {
        if ($id < 0) {
            return $this->redirectToRoute('afficher_planning');
        }
        $cours = $em->getRepository('App\Entity\Cours')->find($id);

        $form = $this->createForm(CoursType::class, $cours);
        $form->add('sauvegarder', SubmitType::class, ['label' => 'Éditer']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specialite = $cours->getUE()->getSpecialite()->getId();
            $professeur = $em->getRepository('App\Entity\Professeur')->findProfesseurLibre((int) $cours->getCreneau(), $specialite);
            $salle = $em->getRepository('App\Entity\Salle')->findSalleLibre((int) $cours->getCreneau());

            $cours->setProfesseur($professeur);
            $cours->setSalle($salle);

            $em->flush();

            return $this->redirectToRoute('afficher_planning');
        }

        return $this->render('planning/_form.html.twig', [
            'form' => $form->createView(),
            'edition' => true
        ]);
    }

    /**
     * @Route("/supprimer/{id}",
     *     name="supprimer_seance",
     *     methods={"GET"},
     *     requirements={"id": "\d+"}
     * )
     */
    public function supprimerSeance(Request $request, EntityManagerInterface $em, $id = -1)
    {
        if ($id < 0) {
            return $this->redirectToRoute('afficher_planning');
        }
        $cours = $em->getRepository('App\Entity\Cours')->find($id);

        $em->remove($cours);
        $em->flush();

        return $this->redirectToRoute('afficher_planning');
    }

        /**
     * @Route("/{role}/{semaine}",
     *     name="afficher_planning",
     *     requirements={
     *         "semaine": "-?\d+"
     *     }
     * )
     */
    public function afficherPlanning($role = -1, $semaine = -1, EntityManagerInterface $em)
    {
        // une semaine va du créneau ($semaine - 1 * 20) + 1 à ($semaine - 1 * 20) + 20 ($semaine 1 : 1-20 $semaine 3 : 41-60

        $utilisateur = $this->getUser();

        $estEtudiant = false;
        $estProfesseur = false;
        $estResponsable = false;

        if($utilisateur->getProfesseur() != null) {
            $formations = $em->getRepository('App\Entity\Formation')->findByProfesseurResponsable($utilisateur->getProfesseur()->getId());
            $formationsResp = array();
            foreach($formations as $formation) {
                if($formation->getProfesseurResponsable()->getId() == $utilisateur->getProfesseur()->getId()) {
                    $estResponsable = true;
                    $formationsResp[] = $formation;
                }
            }

            $formationId = $formationsResp[0]->getId();
        }

        if($utilisateur->getProfesseur() != null) {
            $estProfesseur = true;
        }

        if($utilisateur->getEtudiant() != null) {
            $estEtudiant = true;
            $formationId = $utilisateur->getEtudiant()->getPromotion()->getFormation()->getId();
        }

        if($utilisateur->getEtudiant() == null && $utilisateur->getProfesseur() == null) {
            return $this->redirectToRoute("login");
        }

        // si l'url n'est pas complète alors compléter l'url
        if (($role != "etud" && $role != "prof" && $role != "resp") || $semaine < 1 || $semaine > 52) {
            $nSemaine = $semaine;

            if($role != "etud" && $role != "prof") {
                if($estEtudiant) {
                    $role = "etud";
                } else {
                    $role = "prof";
                }
            }

            if ($semaine < 0 || $semaine > 52) {
                $dt = new \DateTime();

                $annee = $em->getRepository('App\Entity\Annee')->findByTimestamp($dt->format('Y-m-d'));
                $debutPromotion = getdate($annee->getDebutPromotion()->getTimestamp());
                $finAnnee = new \DateTime($debutPromotion['year'] . '-12-31');

                if ($dt > $finAnnee) {
                    $nSemaine = intval((getdate($finAnnee->getTimestamp())["yday"] - $debutPromotion["yday"] + getdate($dt->getTimestamp())["yday"] + 1) / 7) + 1;
                } else {
                    $nSemaine = intval((getdate($dt->getTimestamp())["yday"] - $debutPromotion["yday"]) / 7) + 1;
                }
            }

            return $this->redirectToRoute("afficher_planning", [
                'role' => $role,
                'semaine' => $nSemaine
            ]);
        }

        $autoriserEdition = false;

        if($role == "etud" && $estEtudiant) {
            $formationUes = $utilisateur->getEtudiant()->getPromotion()->getFormation()->getFormationUEs()->toArray();
            $ues = array();
            foreach($formationUes as $formationUe) {
                $ues[] = $formationUe->getUe();
            }
            $uesValides = $utilisateur->getEtudiant()->getUE()->toArray();

            $anneeFormation = $utilisateur->getEtudiant()->getPromotion()->getAnneeFormation();

            for($i = 0; $i < count($ues); $i++) {
                foreach($uesValides as $ueValide) {
                    if($ues[$i]->getAnneeFormation() != $anneeFormation || $ueValide->getId() == $ues[$i]->getId()) {
                        array_splice($ues, $i, 1);
                    }
                }
            }

            $seances = $em->getRepository('App\Entity\Cours')->findBySemaineUEs($semaine, $ues);
        } else if($role == "prof" && $estProfesseur) {
            $seances = $em->getRepository('App\Entity\Cours')->findByProfesseur($semaine, $utilisateur->getProfesseur()->getId());
        } else if($role == "resp" && $estResponsable) {
            $formationUes = $utilisateur->getEtudiant()->getPromotion()->getFormation()->getFormationUEs()->toArray();
            $ues = array();
            foreach($formationUes as $formationUe) {
                $ues[] = $formationUe->getUe();
            }
            $seances = $em->getRepository('App\Entity\Cours')->findBySemaineUEs($semaine, $ues);
            $autoriserEdition = true;
        }

        $creneaux = array();

        foreach ($seances as $seance) {
            $creneaux[(($seance["c_creneau"] - 1) % 20)] = $seance;
        }
        $planning = array();

        for ($heure = 0; $heure < 4; $heure++) {
            $planning[$heure] = "";

            for ($jour = 0; $jour < 5; $jour++) {
                $creneau = ($semaine - 1) * 20 + ($jour * 4 + $heure) + 1;

                if (isset($creneaux[($jour * 4) + $heure])) {
                    $planning[$heure] .= <<<EOT
<td class="creneau seance" style="background-color:{$creneaux[($jour * 4) +$heure]["u_couleur"]}" data-id="{$creneaux[($jour * 4) +$heure]["c_id"]}" data-creneau="{$creneau}">
    <div class="course">
        <ul>
            <li>{$creneaux[($jour * 4) +$heure]["u_nomUE"]}</li>
            <li>{$creneaux[($jour * 4) +$heure]["p_nom"]}</li>
            <li>{$creneaux[($jour * 4) +$heure]["s_nom"]}</li>
        </ul>
    </div>
</td>
EOT;
                } else {
                    $planning[$heure] .= <<<EOT
<td class="creneau vide" style="background-color:#dfdfdf" data-creneau="{$creneau}">
    <div class="course">
        <ul>
            <li>Rien</li>
        </ul>
    </div>
</td>
EOT;
                }
            }
        }



        return $this->render('planning/afficher.html.twig', [
            'controller_name' => 'PlanningController',
            'planning' => $planning,
            'semaine' => $semaine,
            'formation' => $formationId,
            'estResponsable' => $estResponsable,
            'user' => $utilisateur,
            'role' => $role,
            'estProfesseur' => $estProfesseur,
            'estEtudiant' => $estEtudiant,
            'autoriserEdition' => $autoriserEdition
        ]);
    }
}
