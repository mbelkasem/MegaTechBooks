<?php

namespace App\Controller\Admin;


use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('categories', 'Category'),
            TextField::new('name'),
            TextField::new('description'),
            NumberField::new('price')->setNumDecimals(2),
            IntegerField::new('stock'),
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

            ImageField::new('image_url')
                ->setUploadDir('public/images/categories')
                
                // ->setUploadedFileNamePattern('images/categories/{% category.getName() %}/[name].[extension]'),
                // ->setUploadedFileNamePattern('images/categories/{{ product.getCategories().getName() }}/[name].[extension]'),

        ];
    }
    
}
