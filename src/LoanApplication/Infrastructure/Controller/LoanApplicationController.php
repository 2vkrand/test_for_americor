<?php

namespace App\LoanApplication\Infrastructure\Controller;

use App\LoanApplication\Application\Request\LoanApplicationRequest;
use App\LoanApplication\Application\Service\LoanApplicationService;
use App\LoanApplication\Domain\Entity\LoanApplication;
use App\LoanApplication\Infrastructure\Adapter\ClientAdapter;
use App\LoanApplication\Infrastructure\Adapter\ProductAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class LoanApplicationController
{
    /**
     * @param LoanApplicationService $loanApplicationService
     * @param ClientAdapter $clientAdapter
     * @param ProductAdapter $productAdapter
     */
    public function __construct(
        private LoanApplicationService $loanApplicationService,
        private ClientAdapter $clientAdapter,
        private ProductAdapter $productAdapter
    ) {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/loan/apply', name: 'loan_application', methods: ['POST'])]
    public function apply(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!isset($data['clientUlid'], $data['productUlid'])) {
                throw new \InvalidArgumentException('Invalid JSON.');
            }

            $loanRequest = new LoanApplicationRequest(
                $this->clientAdapter->getClientInfo($data['clientUlid']),
                $this->productAdapter->getProductInfo($data['productUlid'])
            );

            $result = $this->loanApplicationService->processApplication($loanRequest);

            return new JsonResponse([
                'status' => $result->getStatus(),
                'clientInfo' => [
                    'age' => $result->getClientInfo()->getAge(),
                    'income' => $result->getClientInfo()->getIncome(),
                    'ficoScore' => $result->getClientInfo()->getFicoScore(),
                    'state' => $result->getClientInfo()->getState(),
                    'email' => $result->getClientInfo()->getEmail(),
                ],
                'productInfo' => [
                    'name' => $result->getProductInfo()->getName(),
                    'interestRate' => $result->getProductInfo()->getInterestRate(),
                    'loanTerm' => $result->getProductInfo()->getLoanTerm(),
                ]
            ], Response::HTTP_OK);

        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Unexpected error occurred.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/loan/check', name: 'check_loan_application', methods: ['GET'])]
    public function check(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!isset($data['clientUlid'], $data['productUlid'])) {
                throw new \InvalidArgumentException('Invalid JSON.');
            }

            $loanRequest = new LoanApplicationRequest(
                $this->clientAdapter->getClientInfo($data['clientUlid']),
                $this->productAdapter->getProductInfo($data['productUlid'])
            );

            $result = $this->loanApplicationService->checkApplication($loanRequest);

            return new JsonResponse([
                'checkApplication' => $result->getStatus() !== LoanApplication::REJECT_STATUS ? 'true' : 'false',
            ], Response::HTTP_OK);

        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Unexpected error occurred.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

