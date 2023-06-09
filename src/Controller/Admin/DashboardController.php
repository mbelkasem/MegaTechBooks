<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\TchatMessage;
use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin')]

class DashboardController extends AbstractDashboardController
{
       #[Route('/', name: 'admin_locale')]

    public function index(): Response
    {

            
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');      

        
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MegaTechBooks');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Produits', 'fas fa-list', Product::class);
        yield MenuItem::linkToCrud('Blog', 'fas fa-list', Post::class);
        //yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Commentaire', 'fas fa-list', Comment::class);
        yield MenuItem::linkToCrud('Chat', 'fas fa-list', TchatMessage::class);


    }
}
