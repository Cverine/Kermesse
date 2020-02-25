<?php

namespace App\DataFixtures;

use App\Entity\Stall;
use App\Entity\User;
use App\Entity\Volunteer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i ++) {
            $volunteer = new Volunteer();
            $volunteer->setName($faker->firstName . ' ' . $faker->lastName);
            $volunteer->setEmail($faker->email);
            $volunteer->setPrepare($faker->boolean);
            $volunteer->setOkSensitive($faker->boolean(2));
            $volunteer->setIsSitting($faker->boolean(10));
            $volunteer->setFirstSlot($faker->boolean);
            $volunteer->setSecondSlot($faker->boolean);
            $volunteer->setThirdSlot($faker->boolean);
            $volunteer->setTidy($faker->boolean);
            $manager->persist($volunteer);
        }

        for ($i = 0; $i < 20; $i ++) {
            $stall = new Stall();
             $stall->setName($faker->jobTitle);
             $stall->setNbVolunteer($faker->numberBetween(1, 3));
             $stall->setIsSensitive($faker->boolean(2));
             $stall->setIsSitting($faker->boolean(10));
             $stall->setFirstSlot(true);
             $stall->setSecondSlot(true);
             $stall->setThirdSlot(true);
             $stall->setPrepare(false);
             $stall->setTidy(false);
             $manager->persist($stall);
        }

        $user = new User();
        $user->setEmail("severinelab@protonmail.com");
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'grogro42'));
        $user->addRole("ROLE_ADMIN");
        $manager->persist($user);

        $manager->flush();
    }
}
