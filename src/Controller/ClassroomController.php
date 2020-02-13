<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\ClassroomType;
use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/classroom")
 */
class ClassroomController extends AbstractController
{
    /**
     * @Route("/{page}", defaults={"page": 1}, name="classroom_index", methods={"GET","POST"})
     */
    public function index(int $page, SalleRepository $classroomRepository, Request $request): Response
    {
        $classroom = new Salle();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classroom);
            $entityManager->flush();

            return $this->redirectToRoute('classroom_index');
        }

        $classrooms = $classroomRepository->findAllWithPaging($page, 10);

        $nbPage = intval(ceil(count($classrooms) / 10));

        return $this->render('classroom/index.html.twig', [
            'page' => $page,
            'nbPage' => $nbPage,
            'classrooms' => $classrooms,
            'classroom' => $classroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classroom_show", methods={"GET"})
     */
    public function show(Salle $classroom): Response
    {
        return $this->render('classroom/show.html.twig', [
            'classroom' => $classroom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classroom_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Salle $classroom): Response
    {
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classroom_index');
        }

        return $this->render('classroom/edit.html.twig', [
            'classroom' => $classroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classroom_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Salle $classroom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classroom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classroom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classroom_index');
    }
}
