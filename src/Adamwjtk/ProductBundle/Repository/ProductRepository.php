<?php

namespace AdamwjtkProductBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @var array
     */
    private $where = [
        'more' => ' > ',
        'equal' => ' = ',
        'lower' => ' < '
    ];

    /**
     * @return array
     */
    public function returnAllProducts(): array
    {
        return $this->createQueryBuilder('product')->getQuery()->getResult(2);
    }

    /**
     * @param int $amount
     * @param string $flag
     * @return array
     */
    public function returnProductByAmount(int $amount, string $flag): array
    {
        $qb = $this->createQueryBuilder('product');
        $qb->andWhere('product.amount' . $this->where[$flag] . ' :amount')
            ->setParameter('amount', $amount);
        $qb->add('orderBy', array('product.amount ASC'));
        return $qb->getQuery()->getResult(2);
    }

}