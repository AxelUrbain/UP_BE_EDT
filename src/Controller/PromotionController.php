<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Promotion;
use App\Form\EtudiantPromotionType;
use App\Form\PromotionType;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secretariat/promotion")
 */
class PromotionController extends AbstractController
{
    /**
     * @Route("/page/{page}", defaults={"page": 1}, name="promotion_index", methods={"GET"})
     * @param int $page
     * @param PromotionRepository $promotionRepository
     * @return Response
     */
    public function index(int $page,PromotionRepository $promotionRepository): Response
    {
        $promotions = $promotionRepository->findAllOrderedByYearWithPaging($page, 10);

        $nbPage = intval(ceil(count($promotions) / 10));

        return $this->render('promotion/index.html.twig', [
            'promotions' => $promotions,
            'page' => $page,
            'nbPage' => $nbPage,
        ]);
    }

    /**
     * @Route("/new", name="promotion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();

            return $this->redirectToRoute('promotion_index');
        }

        return $this->render('promotion/new.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="promotion_show", methods={"GET"})
     * @param Promotion $promotion
     * @return Response
     */
    public function show(Promotion $promotion): Response
    {
        $students = $this->getDoctrine()->getRepository(Etudiant::class)->findByPromotionId($promotion);

        return $this->render('promotion/show.html.twig', [
            'promotion' => $promotion,
            'students' => $students,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="promotion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Promotion $promotion): Response
    {
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotion_index');
        }

        return $this->render('promotion/edit.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/students/{id}/edit", name="add_student_to_promotion", methods={"GET","POST"})
     */
    public function addStudentToPromotion(Request $request, Promotion $promotion): Response
    {
        $studentsToRemove = $this->getDoctrine()->getRepository(Etudiant::class)->findBy(['promotion' => $promotion->getId()]);
        $form = $this->createForm(EtudiantPromotionType::class, $promotion);
        $form->handleRequest($request);

        foreach ($studentsToRemove as $student){
            $student->setPromotion(null);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $newStudentsIds = $request->request->get('etudiant_promotion')['etudiants'];

            $er = $this->getDoctrine()->getRepository(Etudiant::class);

            foreach ($newStudentsIds as $studentId){
                $student = $er->find($studentId);
                $student->setPromotion($promotion);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotion_index');
        }

        return $this->render('promotion/edit.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="promotion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Promotion $promotion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($promotion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('promotion_index');
    }
}
