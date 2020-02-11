<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/planning")
 */
class PlanningController extends AbstractController
{
    /**
     * @Route("/{semaine}", name="afficher_planning")
     */
    public function afficherPlanning($semaine = 1)
    {
        // une semaine va du créneau ($semaine - 1 * 20) + 1 à ($semaine - 1 * 20) + 20 ($semaine 1 : 1-20 $semaine 3 : 41-60

        $seances = [
            [
                "creneau" => 1,
                "ue" => "Algorithmie appliquée",
                "couleur" => "#72a4dd",
                "professeur" => "Marcel Pagnol",
                "salle" => "A13-01128"
            ],
            [
                "creneau" => 3,
                "ue" => "Algorithmie appliquée",
                "couleur" => "#72a4dd",
                "professeur" => "Marcel Pagnol",
                "salle" => "A13-01128"
            ],
            [
                "creneau" => 9,
                "ue" => "Algorithmie appliquée",
                "couleur" => "#72a4dd",
                "professeur" => "Marcel Pagnol",
                "salle" => "A13-01128"
            ],
            [
                "creneau" => 10,
                "ue" => "Algorithmie appliquée",
                "couleur" => "#72a4dd",
                "professeur" => "Marcel Pagnol",
                "salle" => "A13-01128"
            ],
            [
                "creneau" => 10,
                "ue" => "Algorithmie appliquée",
                "couleur" => "#72a4dd",
                "professeur" => "Marcel Pagnol",
                "salle" => "A13-01128"
            ],
            [
                "creneau" => 19,
                "ue" => "Test",
                "couleur" => "#ef8d31",
                "professeur" => "test",
                "salle" => "test"
            ]
        ];

        $creneaux = array();

        foreach($seances as $seance) {
            $creneaux[(($seance["creneau"] - 1) % 20)] = $seance;
        }
        $planning = array();

        for($heure = 0 ; $heure < 4 ; $heure++) {
            $planning[$heure] = "";

            for($jour = 0 ; $jour < 5 ; $jour++)  {
                if(isset($creneaux[($jour * 4) + $heure])) {
                    $planning[$heure] .= <<<EOT
<td style="background-color:{$creneaux[($jour * 4) + $heure]["couleur"]}">
    <div class="course">
        <ul>
            <li>{$creneaux[($jour * 4) + $heure]["ue"]}</li>
            <li>{$creneaux[($jour * 4) + $heure]["professeur"]}</li>
            <li>{$creneaux[($jour * 4) + $heure]["salle"]}</li>
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

        return $this->render('planning/show.html.twig', [
            'controller_name' => 'PlanningController',
            'planning' => $planning,
            'semaine' => $semaine
        ]);
    }
}
