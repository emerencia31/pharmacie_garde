<?php

namespace App\DataFixtures;

use App\Entity\DetailGarde;
use App\Entity\Garde;
use App\Entity\User;
use App\Repository\PharmacieRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UsersFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);

        $admin = new User();
        $admin->setEmail("admin@garde.com");
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->encoder->encodePassword($admin, 'passer'));
        $admin->setIsVerified(1);

        $user = new User();
        $user->setEmail("client@garde.com");
        $user->setRoles([]);
        $user->setPassword($this->encoder->encodePassword($user, 'passer'));
        $user->setIsVerified(1);

        $manager->persist($admin);
        $manager->persist($user);

        $manager->flush();
        for ($i = 1; $i <= 50; $i++) {
            $u = new User();
            $u->setEmail($faker->email);
            if ($i <= 25)
                $u->setRoles(["ROLE_RESPONSABLE"]);
            else
                $u->setRoles([]);
            $u->setPassword($this->encoder->encodePassword($user, 'azerty'));
            $u->setIsVerified($faker->numberBetween(0, 1));
            $manager->persist($u);
            if ($i <= 25)
                $this->addReference('user_' . $i, $u);
        }
        $manager->flush();

    }
}
