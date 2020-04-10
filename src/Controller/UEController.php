<?php

namespace App\Controller;

use App\Entity\UE;
use App\Form\UEType;
use App\Repository\UERepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/secretariat/ue")
 */
class UEController extends AbstractController
{
    /**
     * @Route("/page/{page}", defaults={"page": 1}, name="ue_index", methods={"GET","POST"})
     */
    public function index(int $page, UERepository $ueRepository, Request $request): Response
    {

        $ue = new UE();
        $form = $this->createForm(UEType::class, $ue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ue);
            $entityManager->flush();

            return $this->redirectToRoute('ue_index');
        }

        $ues = $ueRepository->findAllWithPaging($page, 10);

        $nbPage = intval(ceil(count($ues) / 10));

        return $this->render('ue/index.html.twig', [
            'ues' => $ues,
            'ue' => $ue,
            'page' => $page,
            'nbPage' => $nbPage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="ue_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $uE = new UE();
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($uE);
            $entityManager->flush();

            return $this->redirectToRoute('ue_index');
        }

        return $this->render('ue/new.html.twig', [
            'ue' => $uE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ue_show", methods={"GET"})
     */
    public function show(UE $uE): Response
    {
        return $this->render('ue/show.html.twig', [
            'ue' => $uE,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ue_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UE $uE): Response
    {
        $form = $this->createForm(UEType::class, $uE);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ue_index');
        }

        return $this->render('ue/edit.html.twig', [
            'ue' => $uE,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ue_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UE $uE): Response
    {
        if ($this->isCsrfTokenValid('delete'.$uE->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($uE);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ue_index');
    }
}
