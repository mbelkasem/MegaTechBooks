<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Repository\OrderDetailRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PayementController extends AbstractController
{
    #[Route('/payement', name: 'app_payement')]
    public function index(ProductRepository $productRepository,
                          SessionInterface $session,
                           EntityManagerInterface $entityManager,
                            OrderRepository $orderRepository,
                            UserRepository $userRepository): Response

    {

        // On récupére le panier actuel
        $panier = $session->get("panier", []);

        // Créer un tableau pour stocker les détails de commande
        $orderDetails = [];


        foreach($panier as $id => $quantite){
            $product = $productRepository->find($id);
            $dataPanier[] = [
                "product" => $product,
                "quantite" => $quantite
            ];
            $prixTotal = $product->getPrice() * $quantite;
            $order = new Order();

            //donneer test
            $user = $userRepository->find(1);
            $order->setUser($user);

            //$order->setUser($this->getUser());

            //Créer la reference de la commande
            $ref = date("ymd");
            $count = $orderRepository->countByRef($ref) + 1;
            $ref .= (str_pad($count,4,'0',STR_PAD_LEFT));
            $ref= strtoupper($ref);

            $order->setReference($ref);
            $order->setCreatedAt(new \DateTimeImmutable());
            $order->setPayed(true);

              $orderDetail = new OrderDetail();
              $orderDetail->setProducts($product);
              $orderDetail->setQuantity($quantite);
              $orderDetail->setPrice($product->getPrice());
              $orderDetail->setOrders($order);

            $orderDetails[] = $orderDetail; // Ajouter le détail de commande au tableau

            // Persister la réservation dans la base de données
            $entityManager->persist($order);
        }


        // Persister tous les OrderDetail en une seule fois
        foreach ($orderDetails as $orderDetail) {
            $entityManager->persist($orderDetail);
        }

        $entityManager->flush();

        return $this->render('payement/index.html.twig', [
            'controller_name' => 'PayementController',
        ]);
    }
}


