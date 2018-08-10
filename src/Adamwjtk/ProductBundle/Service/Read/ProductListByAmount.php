<?php

namespace AdamwjtkProductBundle\Service\Read;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ProductListByAmount
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * ProductListByAmountEqual constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $amount
     * @param string $flag ['equal' or 'lower' or 'more']
     * @return array
     */
    public function list(int $amount, string $flag): array
    {
        return $this->em->getRepository('AdamwjtkProductBundle:Product')
            ->returnProductByAmount($amount, $flag);
    }
}