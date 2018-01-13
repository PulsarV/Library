<?php

namespace Tests\AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\TestCase;

class TagControllerTest extends TestCase
{
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/tag');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Online Library', $crawler->filter('.jumbotron h1')->text());
        $this->assertEquals(1, $crawler->filter('.navbar')->count());
        $this->assertEquals(1, $crawler->filter('.container .panel')->count());
        $this->assertContains('Tags', $crawler->filter('.container .panel h4')->text());
        $this->assertEquals(1, $crawler->filter('.container .panel table')->count());
        $this->assertEquals(1, $crawler->filter('.container .panel .pagination')->count());
        $this->assertEquals(1, $crawler->filter('footer')->count());
    }

    public function testNew()
    {
        $crawler = $this->client->request('GET', '/tag/new');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Create new tag', $crawler->filter('.modal .modal-header .modal-title')->text());
        $this->assertEquals(1, $crawler->filter('.modal .modal-header button.close')->count());
        $this->assertEquals(1, $crawler->filter('.modal form #app_bundle_tag_type_name')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-primary')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-secondary')->count());

        $form = $this->client->getCrawler()->selectButton('Save')->form();
        self::assertSame(Request::METHOD_POST, $form->getMethod());

        $form['app_bundle_tag_type[name]'] = 'Test Tag';

        $this->client->submit($form);

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertContains('SUCCESS', $this->client->getResponse()->getContent());
    }

    public function testEdit()
    {
        $crawler = $this->client->request('GET', '/tag/12/edit');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Edit tag', $crawler->filter('.modal .modal-header .modal-title')->text());
        $this->assertEquals(1, $crawler->filter('.modal .modal-header button.close')->count());
        $this->assertEquals(1, $crawler->filter('.modal form #app_bundle_tag_type_name')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-primary')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-secondary')->count());

        $form = $this->client->getCrawler()->selectButton('Save')->form();
        self::assertSame(Request::METHOD_POST, $form->getMethod());

        $form['app_bundle_tag_type[name]'] = 'Test Tag12';

        $this->client->submit($form);

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertContains('SUCCESS', $this->client->getResponse()->getContent());
    }

    public function testDelete()
    {
        $crawler = $this->client->request('GET', '/tag/12/delete');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Delete tag', $crawler->filter('.modal .modal-header .modal-title')->text());
        $this->assertEquals(1, $crawler->filter('.modal .modal-header button.close')->count());
        $this->assertContains('Are you sure you want to delete the tag', $crawler->filter('.modal .modal-body p')->text());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-primary')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-secondary')->count());

        $form = $this->client->getCrawler()->selectButton('Delete')->form();
        $this->assertEquals('DELETE', $form->getValues()['_method']);
        self::assertSame(Request::METHOD_POST, $form->getMethod());

        $this->client->submit($form);

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertContains('SUCCESS', $this->client->getResponse()->getContent());
    }
}
