<?php

namespace App\DataFixtures;

use App\Entity\Commune;
use App\Entity\Localisation;
use App\Entity\Region;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $reqion = new Region();
        $reqion->setNomReg("DAKAR");

        $ville = new Ville();
        $ville->setNomVille("Dakar");
        $ville->setRegion($reqion);

        $commune = new Commune();
        $commune->setNomCom("Medina");
        $commune->setVille($ville);

        $localisation = new Localisation();
        $localisation->setCommune($commune);
        $localisation->setLatitude("XXXXXXXXXXXxxxxx");
        $localisation->setLongitude("XXXXXXXXXXXxxxxx");

        $manager->persist($reqion);
        $manager->persist($ville);
        $manager->persist($commune);
        $manager->persist($localisation);

        $manager->flush();
    }
}
