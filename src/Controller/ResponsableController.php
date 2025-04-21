<?php

namespace App\Controller;

use App\Entity\DetailRespo;
use App\Entity\Responsable;
use App\Form\ResponsableType;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/responsable")
 */
class ResponsableController extends AbstractController
{
    /**
     * @Route("/", name="responsable_index", methods={"GET"})
     */
    public function index(ResponsableRepository $responsableRepository): Response
    {
        return $this->render('responsable/index.html.twig', [
            'responsables' => $responsableRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="responsable_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $responsable = new Responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clause = $_POST['responsable']['clause'];
            $detailR = new DetailRespo();
            $detailR->setClause($clause);
            $detailR->setResponsable($responsable);
            $responsable->setDetailRespo($detailR);
            $entityManager->persist($detailR);
            $entityManager->persist($responsable);
            $entityManager->flush();

            return $this->redirectToRoute('responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('responsable/new.html.twig', [
            'responsable' => $responsable,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="responsable_show", methods={"GET"})
     */
    public function show(Responsable $responsable): Response
    {
        return $this->render('responsable/show.html.twig', [
            'responsable' => $responsable,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="responsable_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Responsable $responsable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('responsable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('responsable/edit.html.twig', [
            'responsable' => $responsable,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="responsable_delete", methods={"POST"})
     */
    public function delete(Request $request, Responsable $responsable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $responsable->getId(), $request->request->get('_token'))) {
            $entityManager->remove($responsable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('responsable_index', [], Response::HTTP_SEE_OTHER);
    }
}
