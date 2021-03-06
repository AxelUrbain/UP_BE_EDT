<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Form\EquipmentsType;
use App\Repository\EquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/equipments")
 */
class EquipmentsController extends AbstractController
{
    /**
     * @Route("/", name="equipments_index", methods={"GET","POST"})
     */
    public function index(EquipementRepository $equipmentsRepository, Request $request): Response
    {
        $equipment = new Equipement();
        $form = $this->createForm(EquipmentsType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipment);
            $entityManager->flush();

            return $this->redirectToRoute('equipments_index');
        }

        return $this->render('equipments/index.html.twig', [
            'equipments' => $equipmentsRepository->findAll(),
            'equipment' => $equipment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipments_show", methods={"GET"})
     */
    public function show(Equipement $equipment): Response
    {
        return $this->render('equipments/afficher.html.twig', [
            'equipment' => $equipment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipement $equipment): Response
    {
        $form = $this->createForm(EquipmentsType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipments_index');
        }

        return $this->render('equipments/edit.html.twig', [
            'equipment' => $equipment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipments_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Equipement $equipment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipments_index');
    }
}
