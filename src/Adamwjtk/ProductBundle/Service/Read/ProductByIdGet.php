<?php

namespace AdamwjtkProductBundle\Service\Read;

use AdamwjtkProductBundle\Entity\Product;
use Doctrine\ORM\EntityManager;

class ProductByIdGet
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ProductByIdGet constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @return Product|null
     */
    public function getProduct(int $id):?Product
    {
        $product = $this->em->getRepository(Product::class)
            ->find($id);
        if (!$product) {
            return null;
        }
        return $product;
    }
}