<?php

namespace AdamwjtkProductBundle\Service\Update;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

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
    public function __construct(EntityManagerInterface $em)
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
        $product = $this->em->getRepository("AdamwjtkProductBundle:Product")
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