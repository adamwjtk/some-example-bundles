<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

    static $id;

    public function testGetAllProduct()
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/product/list');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(true, json_decode($client->getResponse()->getContent())->status);
    }

    public function testPostNewProduct()
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/product/new', ['name' => 'test' . rand(1, 11), 'amount' => rand(0, 99)]);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertEquals(true, json_decode($client->getResponse()->getContent())->status);
        self::$id = json_decode($client->getResponse()->getContent())->body->id;

    }

    public function testGetProductByIdFail()
    {
        $id = self::$id;
        $client = static::createClient();
        $client->request('GET', '/api/v1/product/getby/id/' . $id . $id);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals(false, json_decode($client->getResponse()->getContent())->status);
    }

    public function testGetProductById()
    {
        $id = self::$id;
        $client = static::createClient();
        $uri = '/api/v1/product/getby/id/' . $id;
        $client->request('GET', $uri);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(true, json_decode($client->getResponse()->getContent())->status);
    }

    public function testPutNewProduct()
    {
        $id = self::$id;
        $client = static::createClient();
        $uri = '/api/v1/product/' . $id . '/edit';
        $client->request('PUT', $uri, ['name' => 'test' . rand(1, 11), 'amount' => rand(0, 99)]);
        $this->assertEquals(202, $client->getResponse()->getStatusCode());
        $this->assertEquals(true, json_decode($client->getResponse()->getContent())->status);
    }

    public function testDeleteProduct()
    {
        $id = self::$id;
        $client = static::createClient();
        $uri = '/api/v1/product/' . $id . '/delete';
        $client->request('DELETE', $uri);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(true, json_decode($client->getResponse()->getContent())->status);
    }

}