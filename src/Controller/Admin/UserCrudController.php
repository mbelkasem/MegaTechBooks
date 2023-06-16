<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCrudController extends AbstractCrudController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        // Replace with the appropriate class name and namespace for your user entity
        return \App\Entity\User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $passwordField = TextField::new('password');
        if ($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT) {
            $passwordField->setFormType(PasswordType::class)
                ->setFormTypeOption('attr', ['type' => 'password'])
                ->setFormTypeOption('mapped', false)
                ->setFormTypeOption('required', $pageName === Crud::PAGE_NEW);
        } else {
            $passwordField->hideOnForm();
        }

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            // ->setFormTypeOption('disabled','disabled'),
            ArrayField::new('roles'),
            $passwordField,            
            TextField::new('login'),
            TextField::new('lastname'),
            TextField::new('firstname'),
          
            DateTimeField::new('created_at', 'Schedule')
                ->setFormTypeOptions([
                    'widget' => 'single_text',
                    'html5' => true,
                    'attr' => ['class' => 'js-flatpickr'],
                ])
                ->setCustomOption('widget', 'single_text')
                ->setCustomOption('format', 'yyyy-MM-dd HH:mm:ss')
                ->setCustomOption('locale', 'fr')
                ->setRequired(true),


           TextField::new('address'),
           IntegerField::new('zipcode'),
           TextField::new('city'),
           TextField::new('country'),
            
        
            
            
            
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        
        $this->encodePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function encodePassword(PasswordAuthenticatedUserInterface $entityInstance): void
    {
    $encodedPassword = $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword());
    $entityInstance->setPassword($encodedPassword);
    }
}
