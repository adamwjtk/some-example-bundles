<?php

namespace AdamwjtkProductBundle\Service\Read;

use Doctrine\ORM\EntityManager;

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
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function list(){
        return $this->em->getRepository('AdamwjtkProductBundle:Product')
            ->returnAllProducts();

    }
}