<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository) : Response
    {
        $products = $productRepository->findAll();
        // order products by created date
        usort($products, function (Product $a, Product $b){
            if ($a->getDate() === $b->getDate()) {
                return 0;
            }
            return ($a->getDate() > $b->getDate()) ? -1 : 1;
        });

        return $this->render('base.html.twig', [
            'controller_name' => 'DefaultController',
            'products' => $products,
        ]);
    }
}