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

            ['name'=>'Python Algorithms',
            'description'=>'Apprendre Python Algorithms',
            'price'=>'75',
            'image_url'=>'images\categories\books\img02.jpg',
            'category'=>'books',
            'stock'=>'15',
            ],
            
            ['name'=>'C Algorithms',
            'description'=>'Apprendre le C',
            'price'=>'49',
            'image_url'=>'images\categories\books\img03.jpg',
            'category'=>'books',
            'stock'=>'7',
            ],



            ['name'=>'Lenovo PC',
            'description'=>'Lenovo Laptop Model 1',
            'price'=>'299',
            'image_url'=>'images\categories\computers\img01.jpg',
            'category'=>'computers',
            'stock'=>'5',
            ],

            ['name'=>'Lenovo PC',
            'description'=>'Lenovo Laptop Model 2',
            'price'=>'399',
            'image_url'=>'images\categories\computers\img02.jpg',
            'category'=>'computers',
            'stock'=>'10',
            ],

            ['name'=>'Lenovo PC',
            'description'=>'Lenovo Laptop Model 3',
            'price'=>'499',
            'image_url'=>'images\categories\computers\img03.jpg',
            'category'=>'computers',
            'stock'=>'15',
            ],

            ['name'=>'Denom Ampli',
            'description'=>'Amplificateur Denon',
            'price'=>'1000',
            'image_url'=>'images\categories\hiffis\img01.jpg',
            'category'=>'hiffis',
            'stock'=>'3',
            ],

            ['name'=>'Denom Ampli',
            'description'=>'Amplificateur Technics',
            'price'=>'1500',
            'image_url'=>'images\categories\hiffis\img02.jpg',
            'category'=>'hiffis',
            'stock'=>'2',
            ],

            ['name'=>'Denom Ampli',
            'description'=>'Amplificateur Marantz',
            'price'=>'2500',
            'image_url'=>'images\categories\hiffis\img03.jpg',
            'category'=>'hiffis',
            'stock'=>'4',
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
