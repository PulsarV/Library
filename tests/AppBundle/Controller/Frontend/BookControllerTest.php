<?php

namespace Tests\AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\TestCase;

class BookControllerTest extends TestCase
{
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/book');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Online Library', $crawler->filter('.jumbotron h1')->text());
        $this->assertEquals(1, $crawler->filter('.navbar')->count());
        $this->assertEquals(1, $crawler->filter('.container .panel')->count());
        $this->assertContains('Books', $crawler->filter('.container .panel h4')->text());
        $this->assertEquals(1, $crawler->filter('.container .panel table')->count());
        $this->assertEquals(1, $crawler->filter('.container .panel .pagination')->count());
        $this->assertEquals(1, $crawler->filter('footer')->count());
    }

    public function testNew()
    {
        $crawler = $this->client->request('GET', '/book/new');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Create new book', $crawler->filter('.modal .modal-header .modal-title')->text());
        $this->assertEquals(1, $crawler->filter('.modal .modal-header button.close')->count());
        $this->assertEquals(1, $crawler->filter('.modal form #app_bundle_book_type_name')->count());
        $this->assertEquals(1, $crawler->filter('.modal form #app_bundle_book_type_category')->count());
        $this->assertEquals(1, $crawler->filter('.modal form #app_bundle_book_type_tags')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-primary')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-secondary')->count());

        $form = $this->client->getCrawler()->selectButton('Save')->form();
        self::assertSame(Request::METHOD_POST, $form->getMethod());

        $form['app_bundle_book_type[name]'] = 'Test Book';
        $form['app_bundle_book_type[category]'] = '11';
        $form['app_bundle_book_type[tags]'] = ['1', '2', '3'];

        $this->client->submit($form);

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertContains('SUCCESS', $this->client->getResponse()->getContent());
    }

    public function testEdit()
    {
        $crawler = $this->client->request('GET', '/book/1/edit');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Edit book', $crawler->filter('.modal .modal-header .modal-title')->text());
        $this->assertEquals(1, $crawler->filter('.modal .modal-header button.close')->count());
        $this->assertEquals(1, $crawler->filter('.modal form #app_bundle_book_type_name')->count());
        $this->assertEquals(1, $crawler->filter('.modal form #app_bundle_book_type_category')->count());
        $this->assertEquals(1, $crawler->filter('.modal form #app_bundle_book_type_tags')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-primary')->count());
        $this->assertEquals(1, $crawler->filter('.modal .modal-footer button.btn-secondary')->count());

        $form = $this->client->getCrawler()->selectButton('Save')->form();
        self::assertSame(Request::METHOD_POST, $form->getMethod());

        $form['app_bundle_book_type[name]'] = 'Test Book1';
        $form['app_bundle_book_type[category]'] = '2';
        $form['app_bundle_book_type[tags]'] = ['4', '5', '6'];

        $this->client->submit($form);

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertContains('SUCCESS', $this->client->getResponse()->getContent());
    }

    public function testDelete()
    {
        $crawler = $this->client->request('GET', '/book/1/delete');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Delete book', $crawler->filter('.modal .modal-header .modal-title')->text());
        $this->assertEquals(1, $crawler->filter('.modal .modal-header button.close')->count());
        $this->assertContains('Are you sure you want to delete the book', $crawler->filter('.modal .modal-body p')->text());
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
