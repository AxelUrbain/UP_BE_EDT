<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/planning", name="planning")
 */
class PlanningController extends AbstractController
{
    /**
     * @Route("/{week}", name="showPlanning")
     */
    public function showPlanning()
    {

        $week = 1;

        $courses = [
            1 => [
                "ue" => "Algorithmie appliquée",
                "color" => "#72a4dd",
                "teacher" => "Marcel Pagnol",
                "room" => "A13-01128"
            ],
            3 => [
                "ue" => "Algorithmie appliquée",
                "color" => "#72a4dd",
                "teacher" => "Marcel Pagnol",
                "room" => "A13-01128"
            ],
            9 => [
                "ue" => "Algorithmie appliquée",
                "color" => "#72a4dd",
                "teacher" => "Marcel Pagnol",
                "room" => "A13-01128"
            ],
            10 => [
                "ue" => "Algorithmie appliquée",
                "color" => "#72a4dd",
                "teacher" => "Marcel Pagnol",
                "room" => "A13-01128"
            ]
        ];

        $planning = [];

        for( $slot = 0 ; $slot < 4 ; $slot++ )
        {
            $planning[$slot] = "";

            for( $day = 0 ; $day < 5 ; $day++)
            {
                if( isset($courses[($day * 4) + $slot + 1]) )
                {
                    $planning[$slot] .= <<<EOT
<td style="background-color:{$courses[($day * 4) + $slot + 1]["color"]}">
    <div class="course">
        <ul>
            <li>{$courses[($day * 4) + $slot + 1]["ue"]}</li>
            <li>{$courses[($day * 4) + $slot + 1]["teacher"]}</li>
            <li>{$courses[($day * 4) + $slot + 1]["room"]}</li>
        </ul>
    </div>
</td>
EOT;
                }
                else
                {
                    $planning[$slot] .= <<<EOT
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
            'planning' => $planning
        ]);
    }
}
