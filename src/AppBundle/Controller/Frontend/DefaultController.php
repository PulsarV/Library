<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller\Frontend
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Template("@App/Frontend/Default/index.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $query = $this->getDoctrine()->getRepository(Book::class)->getFindAllQuery();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), $this->getParameter('main_page_pagination_limit'));

        return [
            'pagination' => $pagination,
        ];
    }
}
