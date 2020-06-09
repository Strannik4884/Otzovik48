<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/{id}", name="product_show", methods={"GET", "POST"})
     * @param Product $product
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param Security $security
     * @return Response
     */
    public function show(Product $product, EntityManagerInterface $em, PaginatorInterface $paginator, Request $request, Security $security): Response
    {
        // get all Product objects
        $query = $em->createQuery(
            'SELECT c
            FROM App\Entity\Comment c
            WHERE c.for_product = :for_product
            ORDER BY c.created_date DESC'
        )->setParameter('for_product', $product);

        // set default sort and  direction properties
        $request->query->set('sort', 'c.created_date');
        $request->query->set('direction', 'desc');
        // get page number
        $page_number = $request->query->getInt('page', 1);
        // set correct pager number
        if ($page_number < 1) {
            $page_number = 1;
        }
        // paginate
        $pagination = $paginator->paginate(
            $query,
            $page_number,
            5
        );
        // create new comment
        $comment = new Comment();
        $comment->setForProduct($product);
        $comment->setByUser($security->getUser());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        // check form
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        // render view
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'pagination' => $pagination,
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }
}
