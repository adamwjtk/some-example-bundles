<?php

namespace AdamwjtkClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RaportsController extends Controller
{

    public function mainAction(){

    }

    public function emptyAmountAction()
    {
        $productsJson = $this->forward('AdamwjtkProductBundle:Product:listAmountEquals',[
           'amount' => 0
        ])->getContent();
        $products = json_decode($productsJson);

        if(false === $products->status){
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=raport.csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            print_r($products->message);
            die;
        }
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=raport.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "id;nazwa;stan\n";
        foreach($products->body->products as $row){
            echo $row->id.";".$row->name.";".$row->amount."\n";
        }
        die;
    }

    public function isAmountAction()
    {
        $productsJson = $this->forward('AdamwjtkProductBundle:Product:listAmountMoreThan',[
            'amount' => 0
        ])->getContent();
        $products = json_decode($productsJson);

        if(false === $products->status){
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=raport.csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            print_r($products->message);
            die;
        }
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=raport.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "id;nazwa;stan\n";
        foreach($products->body->products as $row){
            echo $row->id.";".$row->name.";".$row->amount."\n";
        }
        die;
    }

    public function moreThanAmountAction(int $amount = 5)
    {
        $productsJson = $this->forward('AdamwjtkProductBundle:Product:listAmountMoreThan',[
            'amount' => $amount
        ])->getContent();
        $products = json_decode($productsJson);

        if(false === $products->status){
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=raport.csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            print_r($products->message);
            die;
        }
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=raport.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "id;nazwa;stan\n";
        foreach($products->body->products as $row){
            echo $row->id.";".$row->name.";".$row->amount."\n";
        }
        die;
    }
}
