<?php

namespace BandMergerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FileControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/create');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edit');
    }

    public function testRemove()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/remove');
    }

    public function testValidate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/validate');
    }

    public function testMerge()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/merge');
    }

}
