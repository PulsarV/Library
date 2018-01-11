<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Book;
use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TagController
 * @package AppBundle\Controller\Frontend
 *
 * @Route("/tag")
 */
class TagController extends Controller
{
    /**
     * @Route("/", name="tag_index")
     * @Method("GET")
     * @Template("@App/Frontend/Tag/index.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $query = $this->getDoctrine()->getRepository(Tag::class)->getFindAllQuery();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('pagination_limit'));

        return [
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/new/", options={"expose"=true}, name="tag_new")
     * @Method({"GET", "POST"})
     * @Template("@App/Frontend/newModal.html.twig")
     *
     * @param Request $request
     * @return array|Response
     */
    public function newAction(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag, [
            'action' => $this->generateUrl('tag_new'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_new' => $form->createView(),
            'entity_name' => 'tag',
        ];
    }

    /**
     * @Route("{tag}/edit/", options={"expose"=true}, name="tag_edit")
     * @Method({"GET", "POST"})
     * @Template("@App/Frontend/editModal.html.twig")
     *
     * @param Request $request
     * @param Tag $tag
     * @return array|Response
     */
    public function editAction(Request $request, Tag $tag)
    {
        $form = $this->createForm(TagType::class, $tag, [
            'action' => $this->generateUrl('tag_edit', ['tag' => $tag->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_edit' => $form->createView(),
            'entity_name' => 'tag',
        ];
    }

    /**
     * @Route("{tag}/delete/", options={"expose"=true}, name="tag_delete")
     * @Method({"GET", "DELETE"})
     * @Template("@App/Frontend/deleteModal.html.twig")
     *
     * @param Request $request
     * @param Tag $tag
     * @return array|Response
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createFormBuilder($tag, [
            'method' => Request::METHOD_DELETE,
            'action' => $this->generateUrl('tag_delete', ['tag' => $tag->getId()]),
        ])->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $books = $this->getDoctrine()->getRepository(Book::class)->findByTagNames([$tag->getName()]);
            if ($booksCount = count($books)) {
                return $this->render('@App/Frontend/deleteErrorModal.html.twig', [
                    'entity_name' => 'tag',
                    'rel_entity_name' => 'book',
                    'name' => $tag->getName(),
                    'used_count' => $booksCount,
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();

            return new Response('SUCCESS');
        }

        return [
            'form_delete' => $form->createView(),
            'name' => $tag->getName(),
            'entity_name' => 'tag',
        ];
    }
}