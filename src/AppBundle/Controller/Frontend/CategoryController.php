<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CategoryController
 * @package AppBundle\Controller\Frontend
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="category_index")
     * @Method("GET")
     * @Template("@App/Frontend/Category/index.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $query = $this->getDoctrine()->getRepository(Category::class)->getFindAllQuery();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('pagination_limit'));

        return [
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/new/", options={"expose"=true}, name="category_new")
     * @Method({"GET", "POST"})
     * @Template("@App/Frontend/newModal.html.twig")
     *
     * @param Request $request
     * @return array|Response
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('category_new'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_new' => $form->createView(),
            'entity_name' => 'category',
        ];
    }

    /**
     * @Route("{category}/edit/", options={"expose"=true}, name="category_edit")
     * @Method({"GET", "POST"})
     * @Template("@App/Frontend/editModal.html.twig")
     *
     * @param Request $request
     * @param Category $category
     * @return array|Response
     */
    public function editAction(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('category_edit', ['category' => $category->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_edit' => $form->createView(),
            'entity_name' => 'category',
        ];
    }

    /**
     * @Route("{category}/delete/", options={"expose"=true}, name="category_delete")
     * @Method({"GET", "DELETE"})
     * @Template("@App/Frontend/deleteModal.html.twig")
     *
     * @param Request $request
     * @param Category $category
     * @return array|Response
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createFormBuilder($category, [
            'method' => Request::METHOD_DELETE,
            'action' => $this->generateUrl('category_delete', ['category' => $category->getId()]),
        ])->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($booksCount = $category->getBooks()->count()) {
                return $this->render('@App/Frontend/deleteErrorModal.html.twig', [
                    'entity_name' => 'category',
                    'rel_entity_name' => 'book',
                    'name' => $category->getName(),
                    'used_count' => $booksCount,
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_delete' => $form->createView(),
            'name' => $category->getName(),
            'entity_name' => 'category',
        ];
    }
}