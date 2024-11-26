<?php

namespace Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testCreateProduct(): void
    {
        $client = static::createClient();
        $data = [
            'name' => 'Test Product',
            'interestRate' => 5.5,
            'loanTerm' => 36,
            'loanAmount' => 10000.0
        ];

        $client->request('POST', '/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertResponseStatusCodeSame(201); // Убедимся, что продукт создан
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('ulid', $responseData);
        $this->assertEquals('Test Product', $responseData['name']);
        $this->assertEquals(5.5, $responseData['interestRate']);
        $this->assertEquals(36, $responseData['loanTerm']);
        $this->assertEquals(10000.0, $responseData['loanAmount']);
    }

    public function testGetProduct(): void
    {
        $client = static::createClient();

        $data = [
            'name' => 'Test Product',
            'interestRate' => 5.5,
            'loanTerm' => 36,
            'loanAmount' => 10000.0
        ];

        $client->request('POST', '/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $ulid = $responseData['ulid'];

        $client->request('GET', '/products/' . $ulid);

        $this->assertResponseStatusCodeSame(200);
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($ulid, $responseData['ulid']);
        $this->assertEquals('Test Product', $responseData['name']);
        $this->assertEquals(5.5, $responseData['interestRate']);
        $this->assertEquals(36, $responseData['loanTerm']);
        $this->assertEquals(10000.0, $responseData['loanAmount']);
    }

    public function testUpdateProduct(): void
    {
        $client = static::createClient();

        $data = [
            'name' => 'Test Product',
            'interestRate' => 5.5,
            'loanTerm' => 36,
            'loanAmount' => 10000.0
        ];

        $client->request('POST', '/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $ulid = $responseData['ulid'];

        $updateData = [
            'name' => 'Updated Product',
            'interestRate' => 4.5,
            'loanTerm' => 24,
            'loanAmount' => 15000.0
        ];

        $client->request('PUT', '/products/' . $ulid, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($updateData));

        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals('Product updated', json_decode($client->getResponse()->getContent(), true)['status']);

        $client->request('GET', '/products/' . $ulid);
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('Updated Product', $responseData['name']);
        $this->assertEquals(4.5, $responseData['interestRate']);
        $this->assertEquals(24, $responseData['loanTerm']);
        $this->assertEquals(15000.0, $responseData['loanAmount']);
    }
}
