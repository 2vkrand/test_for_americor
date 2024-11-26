<?php

namespace Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class HealthCheckActionTest extends WebTestCase
{
    public function testRequestRespondedSuccessfulResult(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/health-check');

        $this->assertResponseIsSuccessful();
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('OK', $json['status']);
    }
}
