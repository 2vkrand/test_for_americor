<?php

namespace Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    /**
     * Тест успешного создания клиента
     */
    public function testCreateClientSuccess(): void
    {
        $client = static::createClient();

        $client->request('POST', '/clients', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'firstName' => 'John',
            'lastName' => 'Doe',
            'age' => 30,
            'city' => 'Los Angeles',
            'state' => 'CA',
            'zip' => '90001',
            'ficoScore' => 700,
            'income' => 5000,
            'ssn' => '123456789',
            'email' => 'john.doe@example.com',
            'phoneNumber' => '5551234567',
        ]));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('ulid', $responseData);
        $this->assertEquals('John', $responseData['firstName']);
        $this->assertEquals('Doe', $responseData['lastName']);
        $this->assertEquals(30, $responseData['age']);
        $this->assertEquals('john.doe@example.com', $responseData['email']);
        $this->assertEquals('5551234567', $responseData['phoneNumber']);
    }

    /**
     * Тест с некорректными данными (неполные данные)
     */
    public function testCreateClientInvalidData(): void
    {
        $client = static::createClient();

        $client->request('POST', '/clients', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'firstName' => 'John'
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid input data', $responseData['error']);
    }

    /**
     * Тест создания клиента с некорректным форматом данных
     */
    public function testCreateClientInvalidFicoScore(): void
    {
        $client = static::createClient();

        $client->request('POST', '/clients', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'age' => 30,
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'ficoScore' => 250,
            'income' => 4000,
            'ssn' => '987654321',
            'email' => 'jane.doe@example.com',
            'phoneNumber' => '5559876543',
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertStringContainsString('FICO Score должен быть в диапазоне', $responseData['error']);
    }

    /**
     * Тест успешного обновления клиента
     */
    public function testUpdateClientSuccess(): void
    {
        $client = static::createClient();

        $client->request('POST', '/clients', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'firstName' => 'John',
            'lastName' => 'Doe',
            'age' => 30,
            'city' => 'Los Angeles',
            'state' => 'CA',
            'zip' => '90001',
            'ficoScore' => 700,
            'income' => 5000,
            'ssn' => '123456789',
            'email' => 'john.doe@example.com',
            'phoneNumber' => '5551234567',
        ]));

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $clientUlid = $responseData['ulid'];

        $client->request('PUT', '/clients/' . $clientUlid, [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'firstName' => 'Jane',
            'lastName' => 'Smith',
            'age' => 35,
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '94105',
            'ficoScore' => 750,
            'income' => 7000,
            'ssn' => '987654321',
            'email' => 'jane.smith@example.com',
            'phoneNumber' => '5559876543',
        ]));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('GET', '/clients/' . $clientUlid);
        $updatedClientData = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('Jane', $updatedClientData['firstName']);
        $this->assertEquals('Smith', $updatedClientData['lastName']);
        $this->assertEquals(35, $updatedClientData['age']);
        $this->assertEquals('San Francisco', $updatedClientData['city']);
        $this->assertEquals('CA', $updatedClientData['state']);
        $this->assertEquals('94105', $updatedClientData['zip']);
        $this->assertEquals(750, $updatedClientData['ficoScore']);
        $this->assertEquals(7000, $updatedClientData['income']);
        $this->assertEquals('987654321', $updatedClientData['ssn']);
        $this->assertEquals('jane.smith@example.com', $updatedClientData['email']);
        $this->assertEquals('5559876543', $updatedClientData['phoneNumber']);
    }
}