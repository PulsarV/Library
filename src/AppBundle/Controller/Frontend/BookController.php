<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Book;
use AppBundle\Form\BookType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BookController
 * @package AppBundle\Controller\Frontend
 *
 * @Route("/book")
 */
class BookController extends Controller
{
    /**
     * @Route("", name="book_index")
     * @Method("GET")
     * @Template("@App/Frontend/Book/index.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $query = $this->getDoctrine()->getRepository(Book::class)->getFindAllQuery();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('pagination_limit'));

        return [
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/new", options={"expose"=true}, name="book_new")
     * @Method({"GET", "POST"})
     * @Template("@App/Frontend/newModal.html.twig")
     *
     * @param Request $request
     * @return array|Response
     */
    public function newAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('book_new'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_new' => $form->createView(),
            'entity_name' => 'book',
        ];
    }

    /**
     * @Route("/{book}/edit", options={"expose"=true}, name="book_edit")
     * @Method({"GET", "POST"})
     * @Template("@App/Frontend/editModal.html.twig")
     *
     * @param Request $request
     * @param Book $book
     * @return array|Response
     */
    public function editAction(Request $request, Book $book)
    {
        $form = $this->createForm(BookType::class, $book, [
            'action' => $this->generateUrl('book_edit', ['book' => $book->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_edit' => $form->createView(),
            'entity_name' => 'book',
        ];
    }

    /**
     * @Route("/{book}/delete", options={"expose"=true}, name="book_delete")
     * @Method({"GET", "DELETE"})
     * @Template("@App/Frontend/deleteModal.html.twig")
     *
     * @param Request $request
     * @param Book $book
     * @return array|Response
     */
    public function deleteAction(Request $request, Book $book)
    {
        $form = $this->get('form.factory')->createNamedBuilder('app_bundle_delete_book_type', FormType::class, $book, [
            'method' => Request::METHOD_DELETE,
            'action' => $this->generateUrl('book_delete', ['book' => $book->getId()]),
        ])->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_delete' => $form->createView(),
            'name' => $book->getName(),
            'entity_name' => 'book',
        ];
    }
}