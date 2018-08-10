<?php

namespace AdamwjtkProductBundle\Service\Read;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ProductList
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ProductList constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function list()
    {
        return $this->em->getRepository("AdamwjtkProductBundle:Product")
            ->returnAllProducts();

    }
}