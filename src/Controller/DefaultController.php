<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
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
        // get all Product objects
        $dql   = "SELECT p FROM App\Entity\Product p";
        $query = $em->createQuery($dql);
        // set default sort and  direction properties
        $request->query->set('sort', 'p.date');
        $request->query->set('direction', 'desc');
        // get page number
        $page_number = $request->query->getInt('page', 1);
        // set correct pager number
        if($page_number < 1){
            $page_number = 1;
        }
        // paginate
        $pagination = $paginator->paginate(
            $query,
            $page_number,
            9
        );
        // render view
        return $this->render('base.html.twig', [
            'controller_name' => 'DefaultController',
            'pagination' => $pagination,
        ]);
    }
}