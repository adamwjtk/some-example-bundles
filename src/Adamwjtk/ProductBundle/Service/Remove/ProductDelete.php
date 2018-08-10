<?php

namespace AdamwjtkProductBundle\Service\Remove;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

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
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        $product = $this->em->getRepository("AdamwjtkProductBundle:Product")
            ->find($id);
        if (null === $product) {
            return false;
        }
        $this->em->remove($product);
        $this->em->flush();
        return true;
    }
}