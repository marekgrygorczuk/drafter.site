<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Drafter', $crawler->filter('h1')->text());
    }

    public function testAddRide() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addRide');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
