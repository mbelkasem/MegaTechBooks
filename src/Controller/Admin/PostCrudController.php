<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class PostCrudController extends AbstractCrudController
{
    private Security $security;
    private EntityManagerInterface $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function configureFields(string $pageName): iterable
    {
        $loggedInUser = $this->security->getUser();

        yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('category', 'Category');
        yield TextField::new('title');
        yield TextEditorField::new('description');
        yield DateTimeField::new('created_at', 'Schedule')
            ->setFormTypeOptions([
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-flatpickr'],
            ])
            ->setCustomOption('widget', 'single_text')
            ->setCustomOption('format', 'yyyy-MM-dd HH:mm:ss')
            ->setCustomOption('locale', 'fr')
            ->setRequired(true);
        yield AssociationField::new('user')
            ->hideOnForm()
            ->setValue($loggedInUser);

        yield ImageField::new('image_url')
            ->setUploadDir('public/images/categories');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $loggedInUser = $this->security->getUser();
        
        if ($entityInstance instanceof Post) {
            $entityInstance->setUser($loggedInUser);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }
}
