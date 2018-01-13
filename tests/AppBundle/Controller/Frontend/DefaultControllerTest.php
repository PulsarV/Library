<?php

namespace Tests\AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\TestCase;

class DefaultControllerTest extends TestCase
{
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Online Library', $crawler->filter('.jumbotron h1')->text());
        $this->assertEquals(1, $crawler->filter('.navbar')->count());
        $this->assertEquals(6, $crawler->filter('.container .panel')->count());
        $this->assertEquals(1, $crawler->filter('.container .pagination')->count());
        $this->assertEquals(1, $crawler->filter('footer')->count());
    }
}
