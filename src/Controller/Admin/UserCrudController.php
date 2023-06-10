<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            // ->setFormTypeOption('disabled','disabled'),
            ArrayField::new('roles'),
            TextField::new('password'),
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
    
}
