<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $categories = ['books', 'hiffis', 'computers'];

       foreach ($categories as $record){

            $category = new Category();
            $category->setName($record);
            $manager->persist($category);
            $this->addReference($record, $category);
            
       }

        $manager->flush();
    }
}
