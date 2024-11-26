<?php

namespace App\Products\Infrastructure\Controller;

use App\Products\Application\Request\CreateProductRequest;
use App\Products\Application\Request\UpdateProductRequest;
use App\Products\Application\Service\CreateProductService;
use App\Products\Application\Service\GetProductService;
use App\Products\Application\Service\UpdateProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

readonly class ProductController
{
    /**
     * @param CreateProductService $createProductService
     * @param UpdateProductService $updateProductService
     * @param GetProductService $getProductService
     */
    public function __construct(
        private CreateProductService $createProductService,
        private UpdateProductService $updateProductService,
        private GetProductService $getProductService
    ) {
    }

    /**
     * @param string $ulid
     * @return Response
     */
    #[Route('/products/{ulid}', name: 'products_get', methods: ['GET'])]
    public function getProduct(string $ulid): Response
    {
        try {
            $product = $this->getProductService->execute($ulid);

            return new JsonResponse([
                'ulid' => $product->getUlid(),
                'name' => $product->getName(),
                'interestRate' => $product->getInterestRate(),
                'loanTerm' => $product->getLoanTerm(),
                'loanAmount' => $product->getLoanAmount()
            ], Response::HTTP_OK);

        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/products', name: 'products_create', methods: ['POST'])]
    public function createProduct(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $createProductRequest = new CreateProductRequest($data);
            $product = $this->createProductService->execute($createProductRequest);

            return new JsonResponse([
                'ulid' => $product->getUlid(),
                'name' => $product->getName(),
                'interestRate' => $product->getInterestRate(),
                'loanTerm' => $product->getLoanTerm(),
                'loanAmount' => $product->getLoanAmount()
            ], Response::HTTP_CREATED);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param string $ulid
     * @param Request $request
     * @return Response
     */
    #[Route('/products/{ulid}', name: 'products_update', methods: ['PUT'])]
    public function updateProduct(string $ulid, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $updateProductRequest = new UpdateProductRequest($data);
            $this->updateProductService->execute($ulid, $updateProductRequest);

            return new JsonResponse(['status' => 'Product updated'], Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
