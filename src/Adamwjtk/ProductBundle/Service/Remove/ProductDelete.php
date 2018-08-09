<?php

namespace AdamwjtkProductBundle\Service\Remove;

use AdamwjtkProductBundle\Entity\Product;
use Doctrine\ORM\EntityManager;

class ProductDelete
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ProductDelete constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        $product = $this->em->getRepository(Product::class)
            ->find($id);
        if(null === $product){
            return false;
        }
        $this->em->remove($product);
        $this->em->flush();
        return true;
    }
}