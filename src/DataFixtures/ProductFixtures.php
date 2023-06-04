<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $products =[
            ['name'=>'Learning Algorithms',
            'description'=>'Apprendre l\'Algorithm',
            'price'=>'59',
            'image_url'=>'images\categories\books\img01.jpg',
            'category'=>'books',
            'stock'=>'10',
            ],

            ['name'=>'Lenovo PC',
            'description'=>'Lenovo Laptop',
            'price'=>'499',
            'image_url'=>'images\categories\books\img01.jpg',
            'category'=>'computers',
            'stock'=>'5',
            ],

            ['name'=>'Denom Ampli',
            'description'=>'Amplificateur Denon',
            'price'=>'1000',
            'image_url'=>'images\categories\books\img01.jpg',
            'category'=>'hiffis',
            'stock'=>'3',
            ],
            

        ];

        foreach($products as $record){

            $product = new Product();
            $product->setName($record['name']);
            $product->setDescription($record['description']);
            $product->setPrice($record['price']);
            $product->setImageUrl($record['image_url']);
            $product->setCategories($this->getReference($record['category']));
            $product->setStock($record['stock']);
            $product->setCreatedAt(new \DateTimeImmutable());   
            

            $manager->persist($product);


        }


        $manager->flush();
    }

    public function getDependencies() {
        return [
            CategoryFixtures::class,
        ];
    }
}
