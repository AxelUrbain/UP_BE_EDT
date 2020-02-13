<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

        dump($creneaux);

        for($heure = 0 ; $heure < 4 ; $heure++) {
            $planning[$heure] = "";

            for($jour = 0 ; $jour < 5 ; $jour++)  {
                if(isset($creneaux[($jour * 4) + $heure])) {
                    $planning[$heure] .= <<<EOT
<td class="seance" style="background-color:{$creneaux[($jour * 4) + $heure]["u_couleur"]}" data-id="{$creneaux[($jour * 4) + $heure]["c_id"]}">
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
<td style="background-color:#dfdfdf">
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
     * @Route("/ajouter", name="ajouter_seance", methods={"GET","POST"})
     */
    public function ajouterSeance(Request $request) {
        $cours = new Cours();

        $form = $this->createForm(CoursType::class, $cours);
        $form->add('send', SubmitType::class, ['label' => 'Ajouter']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
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
    public function editerSeance(Request $request, Cours $cours, $id = -1) {

        if( $id < 0) {
            return $this->redirectToRoute('afficher_planning');
        }

        $form = $this->createForm(CoursType::class, $cours);
        $form->add('send', SubmitType::class, ['label' => 'Éditer']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('afficher_planning');
        }

        return $this->render('planning/_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
