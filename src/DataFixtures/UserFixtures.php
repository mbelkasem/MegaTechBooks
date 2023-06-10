<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct (UserPasswordHasherInterface $passwordHasher) 
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $users = [

            ['login' => 'bob',
            'password' => '123',
            'role' => 'ROLE_ADMIN',
            'firstname' => 'Bob',
            'lastname' => 'Sull',
            'email' => 'bob@sull.com',
            'address' => 'rue du champ 5',
            'zipcode' => '1000',
            'city' => 'Brussels',
            'country' => 'BE',
            ],

            ['login' => 'fred',
            'password' => '123',
            'role' => 'ROLE_USER',
            'firstname' => 'Fred',
            'lastname' => 'Sull',
            'email' => 'fred@sull.com',
            'address' => 'rue des étoiles 15',
            'zipcode' => '1000',
            'city' => 'Brussels',
            'country' => 'BE',
            ],
        ];

        foreach ($users as $record) {
            $user = new User();
            $user->setLogin($record['login']);

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user, $record['password']
            );
            $user->setPassword($hashedPassword);
            $user->setRoles([ $record['role'] ]);
            $user->setFirstname($record['firstname']);
            $user->setLastname($record['lastname']);
            $user->setEmail($record['email']);
            $user->setAddress($record['address']);
            $user->setZipcode($record['zipcode']);
            $user->setCity($record['city']);
            $user->setCountry($record['country']);
            $user->setCreatedAt(new \DateTimeImmutable());            

            $manager->persist($user);
            $this->addReference($record['login'], $user);    
        }
        $manager->flush();
    }
}
