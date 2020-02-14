<?php

namespace App\Controller;

use App\Entity\FormationUE;
use App\Form\FormationUEType;
use App\Repository\FormationUERepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formationue")
 */
class FormationUEController extends AbstractController
{
    /**
     * @Route("/", name="formation_ue_index", methods={"GET"})
     */
    public function index(FormationUERepository $formationUERepository): Response
    {
        return $this->render('formation_ue/index.html.twig', [
            'formation_ues' => $formationUERepository->findAll(),
        ]);
    }

    /**
     * @Route("/update_ues", name="update_ues", methods={"GET","POST"})
     */
    public function updateUes(FormationUERepository $formationUERepository, Request $request, EntityManagerInterface $emi): Response
    {
        $formationId = $request->query->get('formationId');
        $annee = $request->query->get('annee');

        $lines = $formationUERepository->findBy(['formation' => $formationId, 'anneeFormation'=>$annee]);

        foreach($lines as $line) {
            $emi->remove($line);
        }

        $emi->flush();

        // dd($lines);

        return $this->redirectToRoute('formation_show', ["id" => $formationId]);
    }

    /**
     * @Route("/new", name="formation_ue_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formationUE = new FormationUE();
        $form = $this->createForm(FormationUEType::class, $formationUE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formationUE);
            $entityManager->flush();

            return $this->redirectToRoute('formation_ue_index');
        }

        return $this->render('formation_ue/new.html.twig', [
            'formation_ue' => $formationUE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_ue_show", methods={"GET"})
     */
    public function show(FormationUE $formationUE): Response
    {
        return $this->render('formation_ue/show.html.twig', [
            'formation_ue' => $formationUE,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_ue_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FormationUE $formationUE): Response
    {
        // dd($formationUE);

        $form = $this->createForm(FormationUEType::class, $formationUE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_ue_index');
        }

        return $this->render('formation_ue/edit.html.twig', [
            'formation_ue' => $formationUE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_ue_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FormationUE $formationUE): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formationUE->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formationUE);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formation_ue_index');
    }
}
