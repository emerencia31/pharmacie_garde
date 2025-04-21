<?php

namespace App\Controller;

use App\Entity\Localisation;
use App\Entity\Pharmacie;
use App\Form\PharmacieType;
use App\Repository\DetailGardeRepository;
use App\Repository\GardeRepository;
use App\Repository\LocalisationRepository;
use App\Repository\PharmacieRepository;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/pharmacie")
 */
class PharmacieController extends AbstractController
{
    /**
     * @Security ("is_granted('ROLE_RESPONSABLE') or is_granted('ROLE_ADMIN')")
     * @Route("/", name="pharmacie_index", methods={"GET"})
     */
    public function index(Request $request, PharmacieRepository $pharmacieRepository, PaginatorInterface $paginator): Response
    {
//        $pharmacies = $pharmacieRepository->findAll();
        $pharmacies = $pharmacieRepository->findBy(array(), array('id' => 'DESC'));
        $pharmacies = $paginator->paginate(
            $pharmacies,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pharmacie/index.html.twig', [
            'pharmacies' => $pharmacies,
        ]);
    }

    /**
     * @Route("/all", name="pharmacie_all", methods={"GET", "POST"})
     */
    public function all(Request $request, EntityManagerInterface $entityManager, LocalisationRepository $localisationRepository,
                        PharmacieRepository $pharmacieRepository, PaginatorInterface $paginator): Response
    {
//        if(isset($params['latitude']) and isset($params['longitude']) and isset($params['distance'])){
//            $query->addSelect("
//            DEGREES(ACOS((SIN(RADIANS(:latitude)) *
//            SIN(RADIANS(profile.Latitude))) + (COS(RADIANS(:latitude))
//            * COS(RADIANS(profile.Latitude)) *
//            COS(RADIANS(:longitude - profile.Longitude))))) *
//            :radius AS distanceMiles")
//                //->addSelect("(distanceMiles * 1.609344) AS distanceKilometres")
//                // ->addSelect("(distanceMiles * 0.868976) AS distanceNauticalMiles")
//                ->setParameter("latitude", $params['latitude'])
//                ->setParameter("longitude", $params['longitude'])
//                ->setParameter("radius", (60 * 1.1515))
//                ->addOrderBy("distanceMiles", "ASC");
//            if ($params['distance'] != 0) {
//                $query->andHaving('distanceMiles < :distance')
//                    ->setParameter('distance', $params['distance']);
//            }
//        }
//        dd($request->request);
        $search = $request->request->get('s', "");
        $distance = $request->request->get('distance', "");
        $longitude = $request->request->get('longSearch', "");
        $latitude = $request->request->get('latSearch', "");
//        dd($disctance);
        if ($search == "" && $distance == "") {
            $pharmacies = $pharmacieRepository->findBy(array(), array('id' => 'DESC'));
        } else {
            if ($distance != "") {
                $conn = $entityManager->getConnection();

//                           (distanceMiles * 1.609344) AS distanceKilometres,
//                           (distanceMiles * 0.868976) AS distanceNauticalMiles
                $sql = '
                    SELECT p.id, DEGREES(ACOS((SIN(RADIANS(' . floatval($latitude) . ')) *
                    SIN(RADIANS(l.latitude))) + (COS(RADIANS(' . floatval($latitude) . '))
                    * COS(RADIANS(l.latitude)) *
                    COS(RADIANS(' . floatval($longitude) . ' - l.longitude))))) *
                    (60 * 1.1515) AS distanceMiles
                    FROM Pharmacie p, Localisation l
                    WHERE l.pharmacie_id = p.id AND p.nom_pharma LIKE "%' . $search . '%"
                    ORDER BY distanceMiles ASC
            ';
//                dd($sql);
                $stmt = $conn->prepare($sql);

                $rs = $stmt->executeQuery()->fetchAllAssociative();

                $pharmacies = [];
                foreach ($rs as $result) {
//                dump($result['distanceMiles'] * 1.609344);
//                if ($result['distanceMiles'] * 1.609344 <= $distance) {
                    $pharmacies[] = $pharmacieRepository->find($result['id']);
//                }
                }
            } else {
                $pharmacies = $pharmacieRepository->createQueryBuilder('o')
                    ->andWhere('o.nom_pharma LIKE :nom')
                    ->setParameter('nom', '%' . strtoupper($search) . '%')
                    ->getQuery()
                    ->getResult();
            }

        }
        $pharmacies = $paginator->paginate(
            $pharmacies,
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('pharmacie/all.html.twig', [
            'pharmacies' => $pharmacies,
            'search' => $search,
            'distance' => $distance,
        ]);
    }


    /**
     * @IsGranted("ROLE_RESPONSABLE")
     * @Route("/new", name="pharmacie_new", methods={"GET", "POST"})
     */
    public
    function new(Request $request, EntityManagerInterface $entityManager, ResponsableRepository $responsableRepository): Response
    {
        $localisation = new Localisation();
        $pharmacie = new Pharmacie();
        $pharmacie->addLocalisation($localisation);
        $form = $this->createForm(PharmacieType::class, $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if ($user->isResponsable()) {
                $imageFile = $form->get('image')->getData();
                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $newFilename = 'ph_' . time() . '.' . $imageFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $imageFile->move(
                            $this->getParameter('kernel.project_dir') . '/public/img/pharmacies',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $pharmacie->setImage($newFilename);
                }
                $pharmacie->addResponsable($responsableRepository->findOneBy(array('user' => $user)));
                $entityManager->persist($pharmacie);
                $entityManager->persist($localisation);
                $entityManager->flush();

                return $this->redirectToRoute('pharmacie_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('pharmacie/new.html.twig', [
            'pharmacie' => $pharmacie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="pharmacie_show", methods={"GET"})
     */
    public function show(Pharmacie $pharmacie, LocalisationRepository $localisationRepository,
                         GardeRepository $gardeRepository, DetailGardeRepository $detailGardeRepository): Response
    {

        $gardes = $gardeRepository->findBy(['pharmacie' => $pharmacie]);
        $details = [];
        foreach ($gardes as $g) {
            $details[] = $detailGardeRepository->findOneBy(['id' => $g->getDetailGarde()->getId()]);
        }
        $localisation = $localisationRepository->findOneBy(['pharmacie' => $pharmacie]);
//        dd($localisation);
        return $this->render('pharmacie/show.html.twig', [
            'pharmacie' => $pharmacie,
            'gardes' => $gardes,
            'details' => $details,
            'lat' => $localisation->getLatitude(),
            'long' => $localisation->getLongitude(),
        ]);
    }

    /**
     * @IsGranted("ROLE_RESPONSABLE")
     * @Route("/{id}/edit", name="pharmacie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Pharmacie $pharmacie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PharmacieType::class, $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('pharmacie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pharmacie/edit.html.twig', [
            'pharmacie' => $pharmacie,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_RESPONSABLE")
     * @Route("/{id}", name="pharmacie_delete", methods={"POST"})
     */
    public function delete(Request $request, Pharmacie $pharmacie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pharmacie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pharmacie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pharmacie_index', [], Response::HTTP_SEE_OTHER);
    }
}
