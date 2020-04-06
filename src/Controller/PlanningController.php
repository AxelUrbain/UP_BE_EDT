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
     * @Route("/{semaine}",
     *     name="afficher_planning",
     *     requirements={"semaine": "\d+"}
     * )
     */
    public function afficherPlanning($semaine = 1, EntityManagerInterface $em)
    {
        // une semaine va du créneau ($semaine - 1 * 20) + 1 à ($semaine - 1 * 20) + 20 ($semaine 1 : 1-20 $semaine 3 : 41-60

        $seances = $em->getRepository('App\Entity\Cours')->findByWeek($semaine);

        $creneaux = array();

        foreach($seances as $seance) {
            $creneaux[(($seance["c_creneau"] - 1) % 20)] = $seance;
        }
        $planning = array();

        for($heure = 0 ; $heure < 4 ; $heure++) {
            $planning[$heure] = "";

            for($jour = 0 ; $jour < 5 ; $jour++)  {
                $creneau = ($semaine - 1) * 20 + ($jour * 4 + $heure) + 1;

                if(isset($creneaux[($jour * 4) + $heure])) {
                    $planning[$heure] .= <<<EOT
<td class="creneau seance" style="background-color:{$creneaux[($jour * 4) + $heure]["u_couleur"]}" data-id="{$creneaux[($jour * 4) + $heure]["c_id"]}" data-creneau="{$creneau}">
    <div class="course">
        <ul>
            <li>{$creneaux[($jour * 4) + $heure]["u_nomUE"]}</li>
            <li>{$creneaux[($jour * 4) + $heure]["p_nom"]}</li>
            <li>{$creneaux[($jour * 4) + $heure]["s_nom"]}</li>
        </ul>
    </div>
</td>
EOT;
                }
                else {
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
            'semaine' => $semaine
        ]);
    }

    /**
     * @Route("/ajouter/{creneau}", name="ajouter_seance", methods={"GET","POST"})
     */
    public function ajouterSeance(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, $creneau = -1) {
        if($creneau < 1) {
            return $this->redirectToRoute('afficher_planning');
        }
        $cours = new Cours();

        $form = $this->createForm(CoursType::class, $cours);
        $form->add('sauvegarder', SubmitType::class, ['label' => 'Ajouter']);
        $form->handleRequest($request);

        if($form->isSubmitted()) {

            $specialite = $cours->getUE()->getSpecialite()->getId();
            $professeur = $em->getRepository('App\Entity\Professeur')->findProfesseurLibre((int)$creneau, $specialite);
            $salle = $em->getRepository('App\Entity\Salle')->findSalleLibre((int)$cours->getCreneau());

            $cours->setCreneau($creneau);
            $cours->setProfesseur($professeur);
            $cours->setSalle($salle);

            $errors = $validator->validate($cours);

            if(count($errors) == 0) {
                $em->persist($cours);
                $em->flush();
            }
            else {
                foreach($errors as $error) {
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
    public function editerSeance(Request $request, EntityManagerInterface $em, $id = -1) {
        if($id < 0) {
            return $this->redirectToRoute('afficher_planning');
        }
        $cours = $em->getRepository('App\Entity\Cours')->find($id);

        $form = $this->createForm(CoursType::class, $cours);
        $form->add('sauvegarder', SubmitType::class, ['label' => 'Éditer']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $specialite = $cours->getUE()->getSpecialite()->getId();
            $professeur = $em->getRepository('App\Entity\Professeur')->findProfesseurLibre((int)$cours->getCreneau(), $specialite);
            $salle = $em->getRepository('App\Entity\Salle')->findSalleLibre((int)$cours->getCreneau());

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
    public function supprimerSeance(Request $request, EntityManagerInterface $em, $id = -1) {
        if($id < 0) {
            return $this->redirectToRoute('afficher_planning');
        }
        $cours = $em->getRepository('App\Entity\Cours')->find($id);

        $em->remove($cours);
        $em->flush();

        return $this->redirectToRoute('afficher_planning');
    }
}
