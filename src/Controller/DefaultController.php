<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request) : Response
    {
//        $products = $productRepository->findAll();
//        // order products by created date
//        usort($products, function (Product $a, Product $b){
//            if ($a->getDate() === $b->getDate()) {
//                return 0;
//            }
//            return ($a->getDate() > $b->getDate()) ? -1 : 1;
//        });

        $dql   = "SELECT p FROM App\Entity\Product p";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1),
            9,
            [
                'defaultSortFieldName' => 'p.date',
                'defaultSortDirection' => 'desc'
            ]
        );

        return $this->render('base.html.twig', [
            'controller_name' => 'DefaultController',
            'pagination' => $pagination,
        ]);
    }
}