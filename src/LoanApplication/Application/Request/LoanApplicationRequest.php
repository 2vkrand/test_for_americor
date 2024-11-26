<?php

namespace App\LoanApplication\Application\Request;

use App\LoanApplication\Domain\DTO\ClientInfoDTO;
use App\LoanApplication\Domain\DTO\ProductInfoDTO;

readonly class LoanApplicationRequest
{
    /**
     * @param ClientInfoDTO $clientInfo
     * @param ProductInfoDTO $productInfo
     */
    public function __construct(
        private ClientInfoDTO $clientInfo,
        private ProductInfoDTO $productInfo
    )
    {}

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
}
