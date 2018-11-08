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

        for ($i = 0; $i < 30; $i ++) {
            $volunteer = new Volunteer();
            $volunteer->setFirstName($faker->firstName);
            $volunteer->setLastName($faker->firstName);
            $volunteer->setOkSensitive($faker->boolean);
            $volunteer->setIsSitting($faker->boolean(10));
            $volunteer->setFirstSlot($faker->boolean);
            $volunteer->setSecondSlot($faker->boolean);
            $volunteer->setThirdSlot($faker->boolean);
            $volunteer->setPrepare($faker->boolean(10));
            $volunteer->setTidy($faker->boolean(10));
            $manager->persist($volunteer);
        }

        for ($i = 0; $i < 50; $i ++) {
            $stall = new Stall();
            $stall->setName($faker->jobTitle);
            $stall->setNbVolunteer($faker->numberBetween(1, 4));
            $stall->setIsSensitive($faker->boolean(5));
            $stall->setIsSitting($faker->boolean(10));
            $stall->setFirstSlot($faker->boolean);
            $stall->setSecondSlot($faker->boolean);
            $stall->setThirdSlot($faker->boolean);
            $stall->setPrepare($faker->boolean(10));
            $stall->setTidy($faker->boolean(10));
            $manager->persist($stall);
        }

        $manager->flush();
    }
}
