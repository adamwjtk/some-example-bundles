<?php

namespace AdamwjtkProductBundle\Service\Create;


use Symfony\Component\HttpFoundation\Request;

class ProductFieldsSet
{

    public $status = false;

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    private $name;

    /**
     * @return null|string
     */
    public function getName():?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    private function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getAmount():?string
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    private function setAmount(int $amount)
    {
        $this->amount = $amount;
    }

    private $amount;

    public function setFields(Request $post)
    {

        $this->setName($post->get('name'));
        $this->setAmount($post->get('amount'));
        $this->status = true;
    }
}