<?php

namespace App\DataFixtures;

use App\Entity\Stall;
use App\Entity\Volunteer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i ++) {
            $volunteer = new Volunteer();
            $volunteer->setFirstName($faker->firstName);
            $volunteer->setLastName($faker->lastName);
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

        $manager->flush();
    }
}
