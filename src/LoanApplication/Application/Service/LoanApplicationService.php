<?php

namespace App\LoanApplication\Application\Service;

use App\LoanApplication\Application\Request\LoanApplicationRequest;
use App\LoanApplication\Domain\Builder\CheckApplicationHandlerChainBuilder;
use App\LoanApplication\Domain\Builder\LoanApplicationHandlerChainBuilder;
use App\LoanApplication\Domain\Entity\LoanApplication;

readonly class LoanApplicationService
{

    /**
     * @param LoanApplicationHandlerChainBuilder $chainBuilder
     */
    public function __construct(
        private LoanApplicationHandlerChainBuilder $chainBuilder,
        private CheckApplicationHandlerChainBuilder $checkApplicationHandlerChainBuilder,
    )
    {}

    /**
     * @param LoanApplicationRequest $request
     * @return LoanApplication
     */
    public function processApplication(LoanApplicationRequest $request): LoanApplication
    {
        $application = new LoanApplication($request->getClientInfo(), $request->getProductInfo());

        $handlerChain = $this->chainBuilder->build();

        return $handlerChain->handle($application);
    }

    public function checkApplication(LoanApplicationRequest $request): LoanApplication
    {
        $application = new LoanApplication($request->getClientInfo(), $request->getProductInfo());

        $handlerChain = $this->checkApplicationHandlerChainBuilder->build();

        return $handlerChain->handle($application);
    }
}
