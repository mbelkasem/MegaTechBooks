<?php

namespace App\Controller\Admin;

use App\Entity\TchatMessage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TchatMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TchatMessage::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('user');
        yield TextField::new('message');
        

    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW);
        $actions->disable(Action::EDIT);

        return $actions;
    }
    
}
