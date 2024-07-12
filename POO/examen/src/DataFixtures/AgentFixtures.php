<?php

namespace App\DataFixtures;

use App\Entity\Agent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class AgentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 10; $i++) { 
            $agent = new Agent();
            $nomComplet = "Agent".$i;
            $agent->setNomComplet($nomComplet);
            $this->addReference($nomComplet,$agent);
            $manager->persist($agent);
            $manager->flush();
        }

    }
}
