<?php

namespace App\LoanApplication\Domain\Entity;

use App\LoanApplication\Domain\DTO\ClientInfoDTO;
use App\LoanApplication\Domain\DTO\ProductInfoDTO;


/**
 * Для сокращении кода (в рамках тестового задания), не создаю представление этой сущности в базе данных
 */
class LoanApplication
{

    const string APPROVE_STATUS = "Approved";

    const string REJECT_STATUS = "Rejected";

    const string PENDING_STATUS = "Pending";

    /**
     * @param ClientInfoDTO $clientInfo
     * @param ProductInfoDTO $productInfo
     * @param string $status
     */
    public function __construct(
        readonly private ClientInfoDTO $clientInfo,
        readonly private ProductInfoDTO $productInfo,
        private string $status = self::PENDING_STATUS)
    {
    }

    /**
     * @return ClientInfoDTO
     */
    public function getClientInfo(): ClientInfoDTO
    {
        return $this->clientInfo;
    }

    /**
     * @return ProductInfoDTO
     */
    public function getProductInfo(): ProductInfoDTO
    {
        return $this->productInfo;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return $this
     */
    public function approve(): self
    {
        $this->status = self::APPROVE_STATUS;

        return $this;
    }

    /**
     * @return $this
     */
    public function reject(): self
    {
        $this->status = self::REJECT_STATUS;

        return $this;
    }
}
