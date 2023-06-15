<?php

namespace App\Controller;

use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande')]
    public function index(OrderDetailRepository $orderDetailRepository,
                            OrderRepository $orderRepository): Response
    {

        //Utilisateur connecté
        $user = $this->getUser();

        //orders de l'utilisateur connecté
        $ordersUser = $orderRepository->findBy(["user" => $user]);

        $orderDetails = [];

        foreach ($ordersUser as $order){
            $orderDetails[] = $orderDetailRepository->findOneBy(["orders" => $order]);
        }


        return $this->render('commande/index.html.twig', [
            'commandes' => $orderDetails ,
        ]);
    }
}
