<?php

namespace App\DataFixtures;

use App\Entity\owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OwnerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $owner = new Owner();
        $owner->setName("Jan Petrák");
        $owner->addCat($this->getReference('cat_1'));
        $manager->persist($owner);

        $manager->flush();

        $owner2 = new Owner();
        $owner2->setName("Pan Jetrák");
        $owner->addCat($this->getReference('cat_2'));
        $manager->persist($owner2);

        $manager->flush();

        $owner3 = new Owner();
        $owner3->setName("Mr. Awesome");
        $owner->addCat($this->getReference('cat_3'));
        $manager->persist($owner3);

        $manager->flush();

        $this->addReference('owner_1', $owner);
        $this->addReference('owner_2', $owner2);
        $this->addReference('owner_3', $owner3);
    }
}
