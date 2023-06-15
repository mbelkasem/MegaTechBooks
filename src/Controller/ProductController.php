<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
    #[Route('/', name: 'app_books')]
    public function books(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/books.html.twig', [
            'products' => $products,
        ]);
    }  
    #[Route('/', name: 'app_computers')]
    public function computers(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/computers.html.twig', [
            'products' => $products,
        ]);
    }    
    #[Route('/', name: 'app_hiffis')]
    public function hiffis(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/hiffis.html.twig', [
            'products' => $products,
        ]);
    }      
}
