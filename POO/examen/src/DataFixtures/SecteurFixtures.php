<?php

namespace App\DataFixtures;

use App\Entity\Secteur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
;

class SecteurFixtures extends Fixture implements DependentFixtureInterface 
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 10; $i++) { 
            $secteur = new Secteur();
            $name = "Secteur".$i;
            $code = "CodeUO".$i;
            $direction = $this->getReference("Direction".$i);
            $secteur->setName($name);
            $secteur->setCodeUO($code);
            $secteur->setDirection($direction);
            //Ajout de agent à secteur
            $ag1 = rand(1,3);
            $ag2 = rand(4,7);
            $ag3 = rand(8,10);
            $secteur->addAgent($this->getReference("Agent".$ag1));
            $secteur->addAgent($this->getReference("Agent".$ag2));
            $secteur->addAgent($this->getReference("Agent".$ag3));
            
            $this->addReference($name,$secteur);
            $manager->persist($secteur);
            $manager->flush();
        }

        $manager->flush();
    }
    public function getDependencies() {
        return array(
            DirectionFixtures::class,
            AgentFixtures::class,
        );
    }
}
