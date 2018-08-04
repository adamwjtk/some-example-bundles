<?php

namespace AdamwjtkProductBundle\Service\Create;

use AdamwjtkProductBundle\Entity\Product;
use Doctrine\ORM\EntityManager;

class ProductAdd
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ProductAdd constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $name
     * @param int $amount
     * @return Product
     */
    public function newProduct(string $name, int $amount = 0): Product
    {
        $product = new Product();

        $product->setName($name);
        $product->setAmount($amount);
        $this->em->persist($product);
        $this->em->flush();
        return $product;
    }
}