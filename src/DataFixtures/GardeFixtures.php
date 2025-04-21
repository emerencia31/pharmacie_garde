<?php

namespace App\DataFixtures;

use App\Entity\DetailGarde;
use App\Entity\Garde;
use App\Repository\PharmacieRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class GardeFixtures extends Fixture
{
    private $pharmaRepo;

    public function __construct(PharmacieRepository $pharmacieRepository)
    {
        $this->pharmaRepo = $pharmacieRepository;
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $pharamacies = $this->pharmaRepo->findAll();
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 1; $i <= sizeof($pharamacies); $i++) {
            if ($i % 3 == 0) {
                $garde = new Garde();
                $garde->setNomGarde("GARDE " . $faker->company);

                $detailGarde = new DetailGarde();
                $detailGarde->setDateFin($faker->dateTime);
                $detailGarde->setDateDebut($faker->dateTime);
                $detailGarde->setHeureDebut($faker->dateTime());
                $detailGarde->setHeureFin($faker->dateTime());

                $detailGarde->setGarde($garde);
                $garde->setDetailGarde($detailGarde);

                $garde->setPharmacie($this->pharmaRepo->find($i));
                $manager->persist($garde);
            }
        }
        $manager->flush();
    }
}
