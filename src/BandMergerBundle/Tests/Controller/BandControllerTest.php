<?php

namespace BandMergerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BandControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/create');
    }

    public function testAdduser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addUser');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edit');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete');
    }

    public function testRemoveuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/removeUser');
    }

    public function testInviteuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/inviteUser');
    }

}
