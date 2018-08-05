<?php

namespace AdamwjtkProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
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

    /**
     * @Route("/getby/id/{id}")
     */
    public function getByIdAction(int $id)
    {
        $service = $this->get('product.product_find_by_id');
        $product = $service->getProduct($id);
        $response = $this->get('main.response');
        if (null != $product) {
            return $response->createResponse(JsonResponse::HTTP_OK,
                true, $response::ProductGetById, [
                    'product' => [
                        'id' => $product->getId(),
                        'amount' => $product->getAmount(),
                        'name' => $product->getName()
                    ]
                ]);
        }
        return $response->createResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            false, $response::ProductGetByIdFalse);
    }

    /**
     * @Route("/delete/{id}", name="api_product_delete")
     *
     */
    public function deleteAction(int $id): JsonResponse
    {
        $product = $this->get('product.product_delete');
        $siRemove = $product->deleteProduct($id);
        $response = $this->get('main.response');

        if ($siRemove) {
            return $response->createResponse(JsonResponse::HTTP_NO_CONTENT,
                true, $response::ProductDeleted, []);
        }
        return $response->createResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            false, $response::ProductDeletedFalse);
    }


    /**
     * @Route("/edit/{id}/{name}/{amount}", name="api_product_edit")
     *
     */
    public function editAction(int $id, string $name, int $amount): JsonResponse
    {
        $product = $this->get('product.product_edit');
        $isChange = $product->editProduct($id, $name, $amount);
        $response = $this->get('main.response');

        if ($isChange) {
            return $response->createResponse(JsonResponse::HTTP_ACCEPTED,
                true, $response::ProductEdited, ['id' => $id]);
        }
        return $response->createResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            false, $response::ProductEditedFalse);
    }

    /**
     * @Route("/new/{name}/{amount}", name="api_product_add")
     *
     */
    public function newAction(string $name, int $amount = 0): JsonResponse
    {
        $product = $this->get('product.product_add');
        $newProduct = $product->newProduct($name, $amount);
        $response = $this->get('main.response');

        if (0 < $newProduct->getId()) {

            return $response->createResponse(JsonResponse::HTTP_CREATED,
                true, $response::ProductCreated, ['id' => $newProduct->getId()]);
        }
        return $response->createResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            false, $response::ProductCreatedFalse);
    }

    /**
     * @Route("/list", name="api_product_list_all")
     */
    public function listAction(): JsonResponse
    {

        $response = $this->get('main.response');
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductList, ['products' => $this->get('product.list')->list()]);
    }

    /**
     * @Route("/list/amount/equal/{amount}")
     */
    public function listAmountEqualsAction(int $amount): JsonResponse
    {
        $response = $this->get('main.response');
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductListAmountEquals . ' ' . $amount, ['products' => $this->get('product.list_where_amount')->list($amount, $this->equalFlag)]);
    }

    /**
     * @Route("/list/amount/lower/{amount}")
     */
    public function listAmountLowerThanAction(int $amount): JsonResponse
    {
        $response = $this->get('main.response');
        return $response->createResponse(JsonResponse::HTTP_OK,
            true, $response::ProductListAmountLowerThan . ' ' . $amount, ['products' => $this->get('product.list_where_amount')->list($amount, $this->loverFlag)]);
    }

    /**
     * @Route("/list/amount/more/{amount}")
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
