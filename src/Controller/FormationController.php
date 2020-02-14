<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\FormationUERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Collection;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/{page}", defaults={"page": 1}, name="formation_index", methods={"GET","POST"})
     */
    public function index(int $page, FormationRepository $formationRepository, Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('formation_index');
        }

        $formations = $formationRepository->findAllWithPaging($page, 10);

        $nbPage = intval(ceil(count($formations) / 10));

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
            'formation' => $formation,
            'page' => $page,
            'nbPage' => $nbPage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation, FormationUERepository $fur): Response
    {
        $annees = $formation->getNbAnnee();
        $uesByYear = new ArrayCollection();

        for ($i = 0; $i < $annees; $i++){
            $uesByYear->add($fur->findUEsByYear($i+1));
        }

        // dd($uesByYear);

        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            'uesByYear' => $uesByYear
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formation_index');
    }

    /**
     * @Route("/{id}/{annee}/chooseUEs", name="choose_UE", methods={"GET","POST","DELETE"})
     */
    public function chooseUE(Request $request, Formation $formation, $annee): Response
    {
        var_dump($annee);
        $ues = $request->query->get('ues');
        dd($ues);

        return $this->render('formation_ue/edit.html.twig', [
            'formation' => $formation
        ]);
    }
}