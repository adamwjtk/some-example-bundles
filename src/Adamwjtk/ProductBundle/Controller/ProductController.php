<?php

namespace AdamwjtkProductBundle\Controller;

use AdamwjtkProductBundle\Service\Core\Response;
use AdamwjtkProductBundle\Service\Create\ProductAdd;
use AdamwjtkProductBundle\Service\Create\ProductFieldsSet;
use AdamwjtkProductBundle\Service\Read\ProductByIdGet;
use AdamwjtkProductBundle\Service\Read\ProductList;
use AdamwjtkProductBundle\Service\Read\ProductListByAmount;
use AdamwjtkProductBundle\Service\Remove\ProductDelete;
use AdamwjtkProductBundle\Service\Update\ProductEdit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class ProductController
 * @package AdamwjtkProductBundle\Controller
 */
class ProductController extends Controller
{
    private const LOWER = 'lower';
    private const MORE = 'more';
    private const EQUAL = 'equal';

    private $loverFlag;
    private $moreFlag;
    private $equalFlag;

    protected $response;
    protected $productList;

    /**
     * ProductController constructor.
     * @param Response $response
     * @param ProductList $productList
     */
    public function __construct(Response $response, ProductList $productList)
    {
        $this->response = $response;
        $this->productList = $productList;
        $this->setEqualFlag();
        $this->setLoverFlag();
        $this->setMoreFlag();
    }

    /**
     * @param int $id
     * @param ProductByIdGet $productByIdGet
     * @return JsonResponse
     */
    public function getProductByIdAction(int $id, ProductByIdGet $productByIdGet)
    {
        $productByIdGet->findProduct($id);

        if (null != $productByIdGet->getProduct()) {
            return $this->response->createResponse(JsonResponse::HTTP_OK,
                true, $this->response::ProductGetById, [
                    'product' => [
                        'id' => $productByIdGet->getProduct()->getId(),
                        'amount' => $productByIdGet->getProduct()->getAmount(),
                        'name' => $productByIdGet->getProduct()->getName()
                    ]
                ]);
        }
        return $this->response->createResponse(JsonResponse::HTTP_NOT_FOUND,
            false, $this->response::ProductGetByIdFalse);
    }

    /**
     * @param int $id
     * @param ProductDelete $productDelete
     * @return JsonResponse
     */
    public function deleteProductAction(int $id, ProductDelete $productDelete): JsonResponse
    {
        $siRemove = $productDelete->deleteProduct($id);

        if ($siRemove) {
            return $this->response->createResponse(JsonResponse::HTTP_OK,
                true, $this->response::ProductDeleted, []);
        }
        return $this->response->createResponse(JsonResponse::HTTP_NOT_FOUND,
            false, $this->response::ProductDeletedFalse);
    }

    /**
     * @param int $id
     * @param ProductEdit $productEdit
     * @param ProductFieldsSet $productFieldsSet
     * @param Request $request
     * @return JsonResponse
     */
    public function editAction(int $id, ProductEdit $productEdit, ProductFieldsSet $productFieldsSet,
                               Request $request): JsonResponse
    {
        $productFieldsSet->setFields($request);

        if ($productFieldsSet->isStatus()) {
            $isChange = $productEdit->editProduct($id, $productFieldsSet->getName(), $productFieldsSet->getAmount());

            if ($isChange) {
                return $this->response->createResponse(JsonResponse::HTTP_ACCEPTED,
                    true, $this->response::ProductEdited, ['id' => $id]);
            }
        }

        return $this->response->createResponse(JsonResponse::HTTP_NOT_FOUND,
            false, $this->response::ProductEditedFalse);
    }

    /**
     * @param Request $request
     * @param ProductFieldsSet $productFieldsSet
     * @param ProductAdd $productAdd
     * @return JsonResponse
     */
    public function postNewAction(Request $request, ProductFieldsSet $productFieldsSet,
                                  ProductAdd $productAdd): JsonResponse
    {

        $productFieldsSet->setFields($request);

        if ($productFieldsSet->isStatus()) {
            $newProduct = $productAdd->newProduct($productFieldsSet->getName(), $productFieldsSet->getAmount());

            if (0 < $newProduct->getId()) {

                return $this->response->createResponse(JsonResponse::HTTP_CREATED,
                    true, $this->response::ProductCreated, ['id' => $newProduct->getId()]);
            }
        }
        return $this->response->createResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            false, $this->response::ProductCreatedFalse);
    }

    /**
     * @return JsonResponse
     */
    public function listAllAction(): JsonResponse
    {
        return $this->response->createResponse(JsonResponse::HTTP_OK,
            true, $this->response::ProductList, ['products' => $this->productList->list()]);
    }

    /**
     * @param int $amount
     * @param ProductListByAmount $productListByAmount
     * @param Response $response
     * @return JsonResponse
     */
    public function listAmountEqualsAction(int $amount, ProductListByAmount $productListByAmount, Response $response): JsonResponse
    {
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductListAmountEquals . ' ' . $amount, ['products' => $productListByAmount->list($amount, $this->equalFlag)]);
    }

    /**
     * @param int $amount
     * @param ProductListByAmount $productListByAmount
     * @param Response $response
     * @return JsonResponse
     */
    public function listAmountLowerThanAction(int $amount, ProductListByAmount $productListByAmount, Response $response): JsonResponse
    {
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductListAmountLowerThan . ' ' . $amount, ['products' => $productListByAmount->list($amount, $this->loverFlag)]);
    }

    /**
     * @param int $amount
     * @param ProductListByAmount $productListByAmount
     * @param Response $response
     * @return JsonResponse
     */
    public function listAmountMoreThanAction(int $amount, ProductListByAmount $productListByAmount, Response $response): JsonResponse
    {
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductListAmountMoreThan . ' ' . $amount, ['products' => $productListByAmount->list($amount, $this->moreFlag)]);
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
