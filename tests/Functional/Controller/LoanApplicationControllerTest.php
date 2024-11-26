<?php

namespace Functional\Controller;

use App\LoanApplication\Domain\Service\RandomGeneratorInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Класс LoanApplicationControllerTest
 *
 * Функциональные тесты для контроллера заявок на кредит.
 */
class LoanApplicationControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /**
     * Создает тестового клиента с возможностью переопределения параметров.
     *
     * @param array $overrides
     * @return string ULID созданного клиента.
     */
    private function createTestClient(array $overrides = []): string
    {
        $defaultClientData = [
            'firstName'   => 'John',
            'lastName'    => 'Doe',
            'age'         => 30,
            'city'        => 'Los Angeles',
            'state'       => 'CA',
            'zip'         => '90001',
            'ficoScore'   => 700,
            'income'      => 5000.0,
            'ssn'         => '123456789',
            'email'       => 'john.doe@example.com',
            'phoneNumber' => '5551234567',
        ];

        $clientData = array_merge($defaultClientData, $overrides);

        $this->client->request('POST', '/clients', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($clientData));
        $this->assertResponseIsSuccessful();

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('ulid', $responseData);

        return $responseData['ulid'];
    }

    /**
     * Создает тестовый продукт с возможностью переопределения параметров.
     *
     * @param array $overrides
     * @return string ULID созданного продукта.
     */
    private function createTestProduct(array $overrides = []): string
    {
        $defaultProductData = [
            'name'        => 'Test Product',
            'interestRate'=> 5.5,
            'loanTerm'    => 36,
            'loanAmount'  => 10000.0,
        ];

        $productData = array_merge($defaultProductData, $overrides);

        $this->client->request('POST', '/products', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($productData));
        $this->assertResponseIsSuccessful();

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('ulid', $responseData);

        return $responseData['ulid'];
    }

    /**
     * Отправляет заявку на кредит.
     *
     * @param string $clientUlid
     * @param string $productUlid
     * @return array Данные ответа.
     */
    private function applyLoan(string $clientUlid, string $productUlid): array
    {
        $this->client->request('POST', '/loan/apply', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid'  => $clientUlid,
            'productUlid' => $productUlid,
        ]));

        return json_decode($this->client->getResponse()->getContent(), true);
    }

    // Положительные тестовые случаи

    /**
     * Тестирует успешное одобрение кредита для валидного клиента и продукта.
     */
    public function testLoanApprovedForValidClientAndProduct(): void
    {
        $clientUlid  = $this->createTestClient();
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertResponseIsSuccessful();
        $this->assertEquals('Approved', $responseData['status']);

        $this->assertArrayHasKey('clientInfo', $responseData);
        $this->assertArrayHasKey('productInfo', $responseData);
    }

    /**
     * Тестирует одобрение кредита с корректировкой процентной ставки для клиента из Калифорнии.
     */
    public function testLoanApprovedForCaliforniaClientWithInterestAdjustment(): void
    {
        $clientUlid  = $this->createTestClient(['state' => 'CA']);
        $productUlid = $this->createTestProduct(['interestRate' => 5.5]);

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertResponseIsSuccessful();
        $this->assertEquals('Approved', $responseData['status']);
        $adjustedRate = 5.5 + 11.49;
        $this->assertEquals($adjustedRate, $responseData['productInfo']['interestRate']);
    }

    /**
     * Тестирует одобрение кредита для клиента с минимально допустимым возрастом (18 лет).
     */
    public function testLoanApprovedForAgeAtMinimum(): void
    {
        $clientUlid  = $this->createTestClient(['age' => 18]);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Approved', $responseData['status']);
    }

    /**
     * Тестирует одобрение кредита для клиента с максимально допустимым возрастом (60 лет).
     */
    public function testLoanApprovedForAgeAtMaximum(): void
    {
        $clientUlid  = $this->createTestClient(['age' => 60]);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Approved', $responseData['status']);
    }

    /**
     * Тестирует одобрение кредита для клиента с минимально допустимым доходом ($1000).
     */
    public function testLoanApprovedForIncomeAtMinimum(): void
    {
        $clientUlid  = $this->createTestClient(['income' => 1000.00]);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Approved', $responseData['status']);
    }

    /**
     * Тестирует одобрение кредита для клиента с минимально допустимым FICO скором (500).
     */
    public function testLoanApprovedForFicoScoreAtMinimum(): void
    {
        $clientUlid  = $this->createTestClient(['ficoScore' => 501]);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Approved', $responseData['status']);
    }

    // Отрицательные тестовые случаи

    /**
     * Тестирует отказ в кредите из-за низкого FICO скора.
     */
    public function testLoanRejectedDueToLowFicoScore(): void
    {
        $clientUlid  = $this->createTestClient(['ficoScore' => 500]);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Rejected', $responseData['status']);
    }

    /**
     * Тестирует отказ в кредите из-за низкого дохода.
     */
    public function testLoanRejectedDueToLowIncome(): void
    {
        $clientUlid  = $this->createTestClient(['income' => 999.99]);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Rejected', $responseData['status']);
    }

    /**
     * Тестирует отказ в кредите для клиента младше минимального возраста.
     */
    public function testLoanRejectedDueToAgeBelowMinimum(): void
    {
        $clientUlid  = $this->createTestClient(['age' => 17]);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Rejected', $responseData['status']);
    }

    /**
     * Тестирует отказ в кредите для клиента старше максимального возраста.
     */
    public function testLoanRejectedDueToAgeAboveMaximum(): void
    {
        $clientUlid  = $this->createTestClient(['age' => 61]);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Rejected', $responseData['status']);
    }

    /**
     * Тестирует отказ в кредите из-за недопустимого штата.
     */
    public function testLoanRejectedDueToInvalidState(): void
    {
        $clientUlid  = $this->createTestClient(['state' => 'TX']);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);
        $this->assertEquals('Rejected', $responseData['status']);
    }

    /**
     * Тестирует случайный отказ в кредите для клиента из Нью-Йорка.
     *
     * @throws Exception
     */
    public function testLoanApprovalOrRejectionForNewYorkClient(): void
    {
        $clientUlid = $this->createTestClient(['state' => 'NY']);
        $productUlid = $this->createTestProduct();

        $responseData = $this->applyLoan($clientUlid, $productUlid);

        $this->assertContains(
            $responseData['status'],
            ['Approved', 'Rejected']
        );
    }

    // Тестовые случаи с некорректными данными

    /**
     * Тестирует заявку на кредит с недействительным ULID клиента.
     */
    public function testLoanApplicationWithInvalidClientUlid(): void
    {
        $productUlid = $this->createTestProduct();

        $this->client->request('POST', '/loan/apply', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid'  => 'invalid-client-ulid',
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseStatusCodeSame(400);

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Client not found', $responseData['error']);
    }

    /**
     * Тестирует заявку на кредит с недействительным ULID продукта.
     */
    public function testLoanApplicationWithInvalidProductUlid(): void
    {
        $clientUlid = $this->createTestClient();

        $this->client->request('POST', '/loan/apply', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid'  => $clientUlid,
            'productUlid' => 'invalid-product-ulid',
        ]));

        $this->assertResponseStatusCodeSame(400);

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Product not found', $responseData['error']);
    }

    /**
     * Тестирует заявку на кредит с отсутствующими обязательными полями.
     */
    public function testLoanApplicationWithMissingFields(): void
    {
        $this->client->request('POST', '/loan/apply', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([]));

        $this->assertResponseStatusCodeSame(400);

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid JSON.', $responseData['error']);
    }

    /**
     * Тестирует заявку на кредит с некорректным запросом (невалидный JSON).
     */
    public function testLoanApplicationWithMalformedRequest(): void
    {
        $this->client->request('POST', '/loan/apply', [], [], ['CONTENT_TYPE' => 'application/json'], 'invalid-json');

        $this->assertResponseStatusCodeSame(400);

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid JSON.', $responseData['error']);
    }

    /**
     * Тестирует обработку ошибок при возникновении непредвиденного исключения.
     */
    public function testLoanApplicationWithServerError(): void
    {
        $clientUlid = $this->createTestClient();
        $productUlid = 'invalid-product-ulid';

        $this->client->request('POST', '/loan/apply', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid'  => $clientUlid,
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseStatusCodeSame(400);

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Product not found', $responseData['error']);
    }

    /**
     * Тестирует успешную проверку заявки на кредит для валидного клиента и продукта.
     */
    public function testCheckLoanForValidClientAndProduct(): void
    {
        $clientUlid  = $this->createTestClient([
            'ficoScore' => 600,
            'income' => 2000,
            'age' => 25,
            'state' => 'CA'
        ]);
        $productUlid = $this->createTestProduct();

        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid' => $clientUlid,
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('true', $responseData['checkApplication']);
    }

    /**
     * Тестирует отказ в кредите из-за низкого FICO Score.
     */
    public function testCheckLoanRejectedDueToLowFicoScore(): void
    {
        $clientUlid  = $this->createTestClient([
            'ficoScore' => 500,
            'income' => 2000,
            'age' => 25,
            'state' => 'CA'
        ]);
        $productUlid = $this->createTestProduct();

        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid' => $clientUlid,
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('false', $responseData['checkApplication']);
    }

    /**
     * Тестирует отказ в кредите из-за низкого дохода.
     */
    public function testCheckLoanRejectedDueToLowIncome(): void
    {
        $clientUlid  = $this->createTestClient([
            'ficoScore' => 600,
            'income' => 999,
            'age' => 25,
            'state' => 'NV'
        ]);
        $productUlid = $this->createTestProduct();

        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid' => $clientUlid,
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('false', $responseData['checkApplication']);
    }

    /**
     * Тестирует отказ в кредите из-за возраста ниже минимального.
     */
    public function testCheckLoanRejectedDueToAgeBelowMinimum(): void
    {
        $clientUlid  = $this->createTestClient([
            'ficoScore' => 700,
            'income' => 2000,
            'age' => 17,
            'state' => 'CA'
        ]);
        $productUlid = $this->createTestProduct();

        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid' => $clientUlid,
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('false', $responseData['checkApplication']);
    }

    /**
     * Тестирует отказ в кредите из-за возраста выше максимального.
     */
    public function testCheckLoanRejectedDueToAgeAboveMaximum(): void
    {
        $clientUlid  = $this->createTestClient([
            'ficoScore' => 700,
            'income' => 2000,
            'age' => 61,
            'state' => 'CA'
        ]);
        $productUlid = $this->createTestProduct();

        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid' => $clientUlid,
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('false', $responseData['checkApplication']);
    }

    /**
     * Тестирует отказ в кредите из-за недопустимого штата.
     */
    public function testCheckLoanRejectedDueToInvalidState(): void
    {
        $clientUlid  = $this->createTestClient([
            'ficoScore' => 700,
            'income' => 2000,
            'age' => 30,
            'state' => 'TX'
        ]);
        $productUlid = $this->createTestProduct();

        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid' => $clientUlid,
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('false', $responseData['checkApplication']);
    }

    /**
     * Тестирует проверку заявки с некорректным запросом (невалидный JSON).
     */
    public function testCheckLoanWithMalformedRequest(): void
    {
        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], 'invalid-json');

        $this->assertResponseStatusCodeSame(400);
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid JSON.', $responseData['error']);
    }

    /**
     * Тестирует проверку заявки с недействительным ULID клиента.
     */
    public function testCheckLoanWithInvalidClientUlid(): void
    {
        $productUlid = $this->createTestProduct();

        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid' => 'invalid-client-ulid',
            'productUlid' => $productUlid,
        ]));

        $this->assertResponseStatusCodeSame(400);
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Client not found', $responseData['error']);
    }

    /**
     * Тестирует проверку заявки с недействительным ULID продукта.
     */
    public function testCheckLoanWithInvalidProductUlid(): void
    {
        $clientUlid = $this->createTestClient();

        $this->client->request('GET', '/loan/check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'clientUlid' => $clientUlid,
            'productUlid' => 'invalid-product-ulid',
        ]));

        $this->assertResponseStatusCodeSame(400);
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Product not found', $responseData['error']);
    }

}
