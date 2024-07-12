<?php

namespace App\DataFixtures;

use App\Entity\Direction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class DirectionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 10; $i++) { 
            $direction = new Direction();
            $name = "Direction".$i;
            $direction->setName($name);
            $this->addReference($name,$direction);
            $manager->persist($direction);
            $manager->flush();
        }
    }
}
