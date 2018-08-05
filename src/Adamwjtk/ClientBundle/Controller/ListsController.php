<?php

namespace AdamwjtkClientBundle\Controller;

use AdamwjtkClientBundle\Form\ProductForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListsController extends Controller
{
    public function showProductAllAction()
    {
        return $this->render('@AdamwjtkClient/Product/main_page.html.twig');
    }

    public function deleteAction(int $id, Request $request){
        $jsonResponse = $this->forward('AdamwjtkProductBundle:Product:getById',[
            'id'=>$id
        ])->getContent();
        $product = json_decode($jsonResponse);

        $form = $this->createForm(ProductForm::class,['Name'=>$product->body->product->name
            ,'Amount'=>$product->body->product->amount]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $jsonResponse = $this->forward('AdamwjtkProductBundle:Product:delete',[
                'id' => $product->body->product->id,])->getContent();
            $response = json_decode($jsonResponse);
            if($response->status){
                $this->addFlash('success',$response->message);
            }
            else{
                $this->addFlash('failure',$response->message);
            }
            return $this->redirectToRoute('adamwjtk_client_product_list');
        }

        return $this->render('@AdamwjtkClient/Product/remove.html.twig',[
            'productForm' => $form->createView(),
            'ajax' => false
        ]);
    }

    public function editAction(int $id, Request $request){

        $jsonResponse = $this->forward('AdamwjtkProductBundle:Product:getById',[
            'id'=>$id
        ])->getContent();
        $product = json_decode($jsonResponse);
        $form = $this->createForm(ProductForm::class,['Name'=>$product->body->product->name
            ,'Amount'=>$product->body->product->amount]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $productPost = $form->getData();
            $jsonResponse = $this->forward('AdamwjtkProductBundle:Product:edit',[
                'name' =>  $productPost['Name'],
                'id' => $product->body->product->id,
                'amount' => $productPost['Amount'],
            ])->getContent();
            $response = json_decode($jsonResponse);
            if($response->status){
                $this->addFlash('success',$response->message);
            }
            else{
                $this->addFlash('failure',$response->message);
            }
            return $this->redirectToRoute('adamwjtk_client_product_list');
        }

        return $this->render('@AdamwjtkClient/Product/edit.html.twig',[
            'productForm' => $form->createView(),
            'ajax' => false
        ]);
    }

    public function addAction(Request $request)
    {
        $form = $this->createForm(ProductForm::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();

            unset($form);
            $form = $this->createForm(ProductForm::class);
            return $this->render(
                '@AdamwjtkClient/Product/new.html.twig',[
                    'productForm' => $form->createView(),
                    'ajax' => true,
                    'name_val' => $product['Name'],
                    'amount_val' => $product['Amount']
                ]
            );

        }
        return $this->render('@AdamwjtkClient/Product/new.html.twig',[
            'productForm' => $form->createView(),
            'ajax' => false
        ]);
    }
}
