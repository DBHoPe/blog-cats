<?php

namespace App\DataFixtures;

use App\Entity\Cat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cat = new Cat();
        $cat->setName("Nefi");
        $cat->setDescription("Best cat in the world");
        $cat->setImagePath('https://cdn.pixabay.com/photo/2017/03/14/14/49/cat-2143332_960_720.jpg');
        $manager->persist($cat);

        $manager->flush();

        $cat2 = new Cat();
        $cat2->setName("Micina");
        $cat2->setDescription("Cutest cat in the world");
        $cat->setImagePath("https://cdn.pixabay.com/photo/2017/02/20/18/03/cat-2083492_960_720.jpg");
        $manager->persist($cat2);

        $manager->flush();

        $cat3 = new Cat();
        $cat3->setName("Mr. Pawsome");
        $cat3->setDescription("Coolest cat in the world");
        $manager->persist($cat3);

        $manager->flush();

        $this->addReference('cat_1', $cat);
        $this->addReference('cat_2', $cat2);
        $this->addReference('cat_3', $cat3);
    }
}
