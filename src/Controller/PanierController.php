<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier', methods: ["GET"])]
    public function index(SessionInterface $session,
                            ProductRepository $productRepository): Response
    {

        $panier = $session->get("panier", []);

        //on "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $product = $productRepository->find($id);
            $dataPanier[] = [
                "product" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrice() * $quantite;
        }
        return $this->render('panier/index.html.twig',compact("dataPanier", "total"));
    }


        #[Route("/add/{id}", name: "panier_add")]
        public function add(Product $product, SessionInterface $session){
            // On récupére le panier actuel
            $panier = $session->get("panier", []);

            //Vérifier si le produit existe
            $id = $product->getId();

            if (!isset($panier[$id])) {
                // Ajouter le nouveau produit au panier
                $panier[$id] = 1;
            } else {
                // Incrémenter la quantité du produit existant dans le panier
                $panier[$id]++;
            }
            // On sauvegarde dans la session
            $session->set("panier",$panier);
            return $this->redirectToRoute("app_panier");
        }

            #[Route("/supp/{id}", name: "panier_supp")]
            public function sup(Product $product, SessionInterface $session){
                // On récupére le panier actuel
                $panier = $session->get("panier", []);

                //Vérifier si le produit existe
                $id = $product->getId();

                if(!empty($panier[$id])){
                    if($panier[$id] > 1){
                        $panier[$id]--;
                    }else{
                        unset($panier[$id]);
                    }
                }
                // On sauvegarde dans la session
                $session->set("panier",$panier);
                return $this->redirectToRoute("app_panier");
            }


            #[Route("/delete/{id}", name: "panier_delete")]
            public function delete(Product $product, SessionInterface $session){
                // On récupére le panier actuel
                $panier = $session->get("panier", []);

                //Vérifier si le produit existe
                $id = $product->getId();

                if(!empty($panier[$id])){
                    unset($panier[$id]);
                }

                // On sauvegarde dans la session
                $session->set("panier",$panier);
                return $this->redirectToRoute("app_panier");
            }
            #[Route("/delete", name: "panier_delete_all")]
            public function deleteAll(SessionInterface $session){

                $session->remove("panier");

                return $this->redirectToRoute("app_panier");
            }
}
