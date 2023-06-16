<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
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
    ): Response

    {


        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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

            $product->setStock($product->getStock() - $quantite);
            $prixTotal = $product->getPrice() * $quantite;
            $order = new Order();



            $order->setUser($this->getUser());

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

        $session->remove("panier");

        $this->addFlash('success', 'Nous tenons à vous remercier sincèrement d\'avoir choisi notre service et de nous avoir fait confiance. Nous apprécions votre soutien et espérons que votre expérience d\'achat a été agréable. N\'hésitez pas à nous contacter si vous avez des questions ou des préoccupations. Nous sommes là pour vous aider. Merci encore et à bientôt !');

        return $this->redirectToRoute('app_commande');
    }
}


