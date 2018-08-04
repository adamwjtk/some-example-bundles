<?php

namespace AdamwjtkProductBundle\Service\Update;

use AdamwjtkProductBundle\Entity\Product;
use Doctrine\ORM\EntityManager;

class ProductEdit
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ProductEdit constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $amount
     * @return bool
     */
    public function editProduct(int $id, string $name, int $amount): bool
    {
        $product = $this->em->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            return false;
        }
        $product->setName($name);
        $product->setAmount($amount);
        $this->em->merge($product);
        $this->em->flush();
        return true;
    }
}