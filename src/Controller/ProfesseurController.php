<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("administration/professeur")
 */
class ProfesseurController extends AbstractController
{
    /**
     *  @Route("/{page}", defaults={"page": 1}, name="professeur_index", methods={"GET","POST"})
     */
    public function index(int $page, ProfesseurRepository $professeurRepository): Response
    {
        $professeur = new Professeur();
        $professeurs = $professeurRepository->findAllWithPaging($page, 10);

        $nbPage = intval(ceil(count($professeurs) / 10));

        return $this->render('professeur/index.html.twig', [
            'professeurs' => $professeurs,
            'nbPage' => $nbPage,
            'page' => $page
        ]);
    }

    /**
     * @Route("/new", name="professeur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($professeur);
            $entityManager->flush();

            return $this->redirectToRoute('professeur_index');
        }

        return $this->render('professeur/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="professeur_show", methods={"GET"})
     */
    public function show(Professeur $professeur): Response
    {
        return $this->render('professeur/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="professeur_edit", methods={"GET","POST"})
     */
    public function edit(int $id, Request $request, ProfesseurRepository $professeurRepository): Response
    {
        $newProfesseur = new Professeur();
        $professeur = $professeurRepository->findProfessorById($id);

        $form = $this->createForm(ProfesseurType::class, $newProfesseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('professeur_index');
        }

        return $this->render('professeur/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="professeur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Professeur $professeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($professeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('professeur_index');
    }
}
