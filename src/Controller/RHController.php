<?php

namespace App\Controller;

use App\Entity\HeuresSup;
use App\Form\HeuresSupType;
use App\Repository\HeuresSupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rh")
 */
class RHController extends AbstractController
{
    /**
     * @Route("", name="rh_index")
     */
    public function index(Request $request, EntityManagerInterface $em, HeuresSupRepository $heuresSupRepository)
    {
        $heureSup = new HeuresSup();
        $form = $this->createForm(HeuresSupType::class, $heureSup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($heureSup);
            $entityManager->flush();

            return $this->redirectToRoute('rh_index');
        }

        return $this->render('rh/index.html.twig', [
            'heuresSup' => $heuresSupRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/taux/{id}/edit", name="rh_edit_heure_sup", methods={"GET","POST"})
     */
    public function edit(Request $request, HeuresSup $heureSup): Response
    {
        $form = $this->createForm(HeuresSupType::class, $heureSup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rh_index');
        }

        return $this->render('rh/edit_heuresSup.html.twig', [
            'heureSup' => $heureSup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/heure_sup/{id}", name="rh_delete_heure_sup", methods={"DELETE"})
     */
    public function delete(Request $request, HeuresSup $heureSup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$heureSup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($heureSup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rh_index');
    }
}
