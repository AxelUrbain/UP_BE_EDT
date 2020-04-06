<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\UE;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\FormationUERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Collection;

/**
 * @Route("/secretariat/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/chooseUEs", name="choose_UE", methods={"GET", "POST", "DELETE"})
     */
    public function chooseUE(Request $request, FormationUERepository $fur, EntityManagerInterface $em): Response
    {

        $formationId = $request->query->get('id');
        $annee = $request->query->get('annee');

        $checkedUes = $fur->findUEsByYear($request->query->get('annee'));
        $checkedUesIds = [];

        foreach ($checkedUes as $checkedUE) {
            $checkedUesIds[] = $checkedUE['id'];
        }

        $uncheckedUes = [];

        $allUes = $em->getRepository(UE::class)->findAll();
        foreach ($allUes as $ue){
            if (!in_array($ue->getId(), $checkedUesIds)) {
                $uncheckedUes[] = $ue;
            }
        }

        // dd($uncheckedUes);

        return $this->render('formation_ue/choose_UE.html.twig', [
            'checkedUes' => $checkedUes,
            'uncheckedUes' => $uncheckedUes,
            'formationId' => $formationId,
            'annee' => $annee,
        ]);
    }

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
    public function show(Formation $formation, FormationUERepository $fur, EntityManagerInterface $emi): Response
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
}
