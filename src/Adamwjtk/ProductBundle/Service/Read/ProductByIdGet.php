<?php

namespace AdamwjtkProductBundle\Service\Read;

use AdamwjtkProductBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;

class ProductByIdGet
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var null
     */
    private $exception;

    private $product;

    /**
     * @return Product|null
     */
    public function getProduct():?Product
    {
        return $this->product;
    }

    /**
     * @return null|string
     */
    public function getException():?string
    {
        return $this->exception;
    }

    /**
     * ProductByIdGet constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->excepiton = null;
        $this->product = null;
    }

    /**
     * @param int $id
     */
    public function findProduct(int $id)
    {   try{
            $product = $this->em->getRepository(Product::class)
                ->find($id);
            $this->product = $product;
        }catch(EntityNotFoundException $entityNotFoundException){
            $this->excepiton = $entityNotFoundException->getMessage();
        }
    }
}