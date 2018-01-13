<?php

namespace Tests\AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\TestCase;

class BookControllerTest extends TestCase
{
    public function testListByName()
    {
        $requiredResponce = [
            'books' => [
                [
                    'id' => 1,
                    'name' => 'Book1',
                    'category' => ['id' => 1,'name' => 'Category1'],
                    'tags' => [
                        ['id' => 1, 'name' => 'Tag1']
                    ],
                ],
                [
                    'id' => 10,
                    'name' => 'Book10',
                    'category' => ['id' => 10, 'name' => 'Category10'],
                    'tags' => [
                        ['id' => 10, 'name' => 'Tag10']
                    ]

                ],
                [
                    'id' => 11,
                    'name' => 'Book11',
                    'category' => ['id' => 11, 'name' => 'Category11'],
                    'tags' => [
                        ['id' => 11, 'name' => 'Tag11']
                    ]
                ],
            ],
        ];

        $this->client->request('GET', '/api/book/Book1');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode($requiredResponce), $this->client->getResponse()->getContent());
    }

    public function testListByTags()
    {
        $requiredResponce = [
            'books' => [
                [
                    'id' => 1,
                    'name' => 'Book1',
                    'category' => ['id' => 1,'name' => 'Category1'],
                    'tags' => [
                        ['id' => 1, 'name' => 'Tag1']
                    ],
                ],
                [
                    'id' => 2,
                    'name' => 'Book2',
                    'category' => ['id' => 2, 'name' => 'Category2'],
                    'tags' => [
                        ['id' => 2, 'name' => 'Tag2']
                    ]

                ],
            ],
        ];

        $this->client->request('GET', '/api/book/tag/Tag1,Tag2');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode($requiredResponce), $this->client->getResponse()->getContent());
    }

    public function testListByCategory()
    {
        $requiredResponce = [
            'books' => [
                [
                    'id' => 3,
                    'name' => 'Book3',
                    'category' => ['id' => 3,'name' => 'Category3'],
                    'tags' => [
                        ['id' => 3, 'name' => 'Tag3']
                    ],
                ],
            ],
        ];

        $this->client->request('GET', '/api/book/category/Category3');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode($requiredResponce), $this->client->getResponse()->getContent());
    }

    public function testListByCategoryAndTag()
    {
        $requiredResponce = [
            'books' => [
                [
                    'id' => 5,
                    'name' => 'Book5',
                    'category' => ['id' => 5,'name' => 'Category5'],
                    'tags' => [
                        ['id' => 5, 'name' => 'Tag5']
                    ],
                ],
            ],
        ];

        $this->client->request('GET', '/api/book/category/Category5/tag/Tag5');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode($requiredResponce), $this->client->getResponse()->getContent());
    }
}
