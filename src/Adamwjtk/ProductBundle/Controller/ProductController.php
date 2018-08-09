<?php

namespace AdamwjtkProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    private const LOWER = 'lower';
    private const MORE = 'more';
    private const EQUAL = 'equal';

    private $loverFlag;
    private $moreFlag;
    private $equalFlag;

    /**
     * ProductController constructor
     */
    public function __construct()
    {
        $this->setEqualFlag();
        $this->setLoverFlag();
        $this->setMoreFlag();
    }

    public function getProductByIdAction(int $id)
    {
        $service = $this->get('product.product_find_by_id');
        $service->findProduct($id);
        $response = $this->get('main.response');
        if (null != $service->getProduct()) {
            return $response->createResponse(JsonResponse::HTTP_OK,
                true, $response::ProductGetById, [
                    'product' => [
                        'id' => $service->getProduct()->getId(),
                        'amount' => $service->getProduct()->getAmount(),
                        'name' => $service->getProduct()->getName()
                    ]
                ]);
        }
        return $response->createResponse(JsonResponse::HTTP_NOT_FOUND,
            false, $response::ProductGetByIdFalse);
    }

    public function deleteProductAction(int $id): JsonResponse
    {
        $product = $this->get('product.product_delete');
        $siRemove = $product->deleteProduct($id);
        $response = $this->get('main.response');

        if ($siRemove) {
            return $response->createResponse(JsonResponse::HTTP_NO_CONTENT,
                true, $response::ProductDeleted, []);
        }
        return $response->createResponse(JsonResponse::HTTP_NOT_FOUND,
            false, $response::ProductDeletedFalse);
    }

    public function editAction(int $id, string $name, int $amount): JsonResponse
    {
        $product = $this->get('product.product_edit');
        $isChange = $product->editProduct($id, $name, $amount);
        $response = $this->get('main.response');

        if ($isChange) {
            return $response->createResponse(JsonResponse::HTTP_ACCEPTED,
                true, $response::ProductEdited, ['id' => $id]);
        }
        return $response->createResponse(JsonResponse::HTTP_NOT_FOUND,
            false, $response::ProductEditedFalse);
    }


    public function postNewAction(Request $request): JsonResponse
    {
        $setFieldService = $this->get('product.field_set');
        $response = $this->get('main.response');
        $setFieldService->setFields($request);

        if($setFieldService->isStatus()){
            $product = $this->get('product.product_add');
            $newProduct = $product->newProduct($setFieldService->getName(), $setFieldService->get);

            if (0 < $newProduct->getId()) {

                return $response->createResponse(JsonResponse::HTTP_CREATED,
                    true, $response::ProductCreated, ['id' => $newProduct->getId()]);
            }
        }
        return $response->createResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            false, $response::ProductCreatedFalse);
    }

    /**
     * @return JsonResponse
     */
    public function listAllAction(): JsonResponse
    {

        $response = $this->get('main.response');
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductList, ['products' => $this->get('product.list')->list()]);
    }

    /**
     * @param int $amount
     * @return JsonResponse
     */
    public function listAmountEqualsAction(int $amount): JsonResponse
    {
        $response = $this->get('main.response');
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductListAmountEquals . ' ' . $amount, ['products' => $this->get('product.list_where_amount')->list($amount, $this->equalFlag)]);
    }

    /**
     * @param int $amount
     * @return JsonResponse
     */
    public function listAmountLowerThanAction(int $amount): JsonResponse
    {
        $response = $this->get('main.response');
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductListAmountLowerThan . ' ' . $amount, ['products' => $this->get('product.list_where_amount')->list($amount, $this->loverFlag)]);
    }

    /**
     * @param int $amount
     * @return JsonResponse
     */
    public function listAmountMoreThanAction(int $amount): JsonResponse
    {
        $response = $this->get('main.response');
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductListAmountMoreThan . ' ' . $amount, ['products' => $this->get('product.list_where_amount')->list($amount, $this->moreFlag)]);
    }

    public function setLoverFlag()
    {
        $this->loverFlag = self::LOWER;
    }


    public function setMoreFlag()
    {
        $this->moreFlag = self::MORE;
    }

    public function setEqualFlag()
    {
        $this->equalFlag = self::EQUAL;
    }

}
