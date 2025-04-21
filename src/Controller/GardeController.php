<?php

namespace App\Controller;

use App\Entity\DetailGarde;
use App\Entity\Garde;
use App\Form\GardeType;
use App\Repository\GardeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/garde")
 */
class GardeController extends AbstractController
{
    /**
     * @Security ("is_granted('ROLE_RESPONSABLE') or is_granted('ROLE_ADMIN')")
     * @Route("/", name="garde_index", methods={"GET"})
     */
    public function index(GardeRepository $gardeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $gardes = $gardeRepository->findAll();
        $gardes = $paginator->paginate(
            $gardes,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('garde/index.html.twig', [
            'gardes' => $gardes,
        ]);
    }

    /**
     * @IsGranted("ROLE_RESPONSABLE")
     * @Route("/new", name="garde_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $detailGarde = new DetailGarde();
        $garde = new Garde();
        $garde->setDetailGarde($detailGarde);
        $form = $this->createForm(GardeType::class, $garde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($garde);
            $entityManager->flush();

            return $this->redirectToRoute('garde_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('garde/new.html.twig', [
            'garde' => $garde,
            'form' => $form,
        ]);
    }

    /**
     * @Security ("is_granted('ROLE_RESPONSABLE') or is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="garde_show", methods={"GET"})
     */
    public function show(Garde $garde): Response
    {
        return $this->render('garde/show.html.twig', [
            'garde' => $garde,
        ]);
    }

    /**
     * @IsGranted("ROLE_RESPONSABLE")
     * @Route("/{id}/edit", name="garde_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Garde $garde, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GardeType::class, $garde);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('garde_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('garde/edit.html.twig', [
            'garde' => $garde,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_RESPONSABLE")
     * @Route("/{id}", name="garde_delete", methods={"POST"})
     */
    public function delete(Request $request, Garde $garde, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$garde->getId(), $request->request->get('_token'))) {
            $entityManager->remove($garde);
            $entityManager->flush();
        }

        return $this->redirectToRoute('garde_index', [], Response::HTTP_SEE_OTHER);
    }
}
