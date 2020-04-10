<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Form\PromotionEtudiantType;
use App\Repository\EtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secretariat/etudiant")
 */
class EtudiantController extends AbstractController
{
    /**
     * @Route("/page/{page}", defaults={"page": 1}, name="etudiant_index", methods={"GET"})
     * @param int $page
     * @param EtudiantRepository $etudiantRepository
     * @return Response
     */
    public function index(int $page, EtudiantRepository $etudiantRepository): Response
    {
        $etudiants = $etudiantRepository->findAllOrderedByNameWithPaging($page, 10);

        $nbPage = intval(ceil(count($etudiants) / 10));

        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
            'page' => $page,
            'nbPage' => $nbPage,
        ]);
    }

    /**
     * @Route("/new", name="etudiant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_show", methods={"GET"})
     */
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etudiant_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Etudiant $etudiant
     * @return Response
     */
    public function edit(Request $request, Etudiant $etudiant): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editByPromotion", name="etudiant_edit_by_formation", methods={"GET","POST"})
     */
    public function editByFormation(Request $request, int $id): Response
    {
        $student = $this->getDoctrine()->getRepository(Etudiant::class)->find($id);
        $form = $this->createForm(PromotionEtudiantType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotion_show', ['id' => $request->query->get('promotionId')]);
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $student,
            'form' => $form->createView(),
            'promotionId' => $request->query->get('promotionId')
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }
}
