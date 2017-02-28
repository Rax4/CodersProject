<?php

namespace BandMergerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ViewControllerTest extends WebTestCase
{
    public function testViewallbands()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewAllBands');
    }

    public function testViewband()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewBand');
    }

    public function testViewproject()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewProject');
    }

}
