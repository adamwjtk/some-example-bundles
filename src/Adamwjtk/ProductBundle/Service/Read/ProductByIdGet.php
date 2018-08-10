<?php

namespace AdamwjtkProductBundle\Service\Read;

use AdamwjtkProductBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->excepiton = null;
        $this->product = null;
    }

    /**
     * @param int $id
     */
    public function findProduct(int $id)
    {
        try {
            $product = $this->em->getRepository("AdamwjtkProductBundle:Product")
                ->find($id);
            $this->product = $product;
        } catch (EntityNotFoundException $entityNotFoundException) {
            $this->excepiton = $entityNotFoundException->getMessage();
        }
    }
}