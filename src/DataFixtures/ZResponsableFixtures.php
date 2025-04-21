<?php


namespace App\DataFixtures;

use App\Entity\DetailRespo;
use App\Entity\Responsable;
use App\Repository\PharmacieRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ZResponsableFixtures extends Fixture
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
        $nbPharmacies = sizeof($pharamacies);
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 1; $i <= 1; $i++) {
            $user = $this->getReference('user_' . $i);
            $responsable = new Responsable();
            $responsable->setPrenom($faker->firstName);
            $responsable->setNom($faker->lastName);
            $responsable->setUser($user);

            $detailRespo = new DetailRespo();
            $detailRespo->setResponsable($responsable);
            $detailRespo->setClause($i % 2 == 0 ? "CDD" : "CDI");
            $detailRespo->setDateDebut(new \DateTime());
            $detailRespo->setDateFin(new \DateTime());

            $responsable->setDetailRespo($detailRespo);
            $x = $faker->numberBetween(0, 5);
            for ($i = 1; $i <= $x; $i++) {
                $ph = $this->pharmaRepo->find($faker->numberBetween($i * 20, (($nbPharmacies / 5) * ($i + 1))-1));
                if($ph == null)
                    $ph = $this->pharmaRepo->find(1);
                $responsable->addPharmacy($ph);
            }
            $manager->persist($detailRespo);
            $manager->persist($responsable);

        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class
        ];
    }
}
