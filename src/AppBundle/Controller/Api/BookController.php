<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Book;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BookController
 * @package AppBundle\Controller\Api
 * @Route("/api/book")
 */
class BookController extends Controller
{
    /**
     * @Route("/{name}", name="api_book_by_name")
     * @Method("GET")
     *
     * @param string $name
     * @return JsonResponse
     */
    public function listByNameAction($name)
    {
        /** @var Book[] $books */
        $books = $this->getDoctrine()->getRepository(Book::class)->findByNameLike($name);

        return $this->json(['books' => $books], 200);
    }

    /**
     * @Route("/tag/{tags}", name="api_book_by_tags")
     * @Method("GET")
     *
     * @param string $tags
     * @return JsonResponse
     */
    public function listByTagsAction($tags)
    {
        $tagNames = array_map('trim', explode(',', $tags));

        /** @var Book[] $books */
        $books = $this->getDoctrine()->getRepository(Book::class)->findByTagNames($tagNames);

        return $this->json(['books' => $books], 200);
    }

    /**
     * @Route("/category/{category}", name="api_book_by_category")
     * @Method("GET")
     *
     * @param string $category
     * @return JsonResponse
     */
    public function listByCategoryAction($category)
    {
        /** @var Book[] $books */
        $books = $this->getDoctrine()->getRepository(Book::class)->findByCategoryName($category);

        return $this->json(['books' => $books], 200);
    }

    /**
     * @Route("/category/{category}/tag/{tag}", name="api_book_by_category_and_tag")
     * @Method("GET")
     *
     * @param string $category
     * @param string $tag
     * @return JsonResponse
     */
    public function listByCategoryAndTagAction($category, $tag)
    {
        /** @var Book[] $books */
        $books = $this->getDoctrine()->getRepository(Book::class)->findByCategoryAndTagName($category, $tag);

        return $this->json(['books' => $books], 200);
    }
}
