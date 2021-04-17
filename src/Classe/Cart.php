<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    
    private $session;
    private $entityManager;
    /************************* */

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    } 

    //function pour ajouter des produits au panier
    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        //pour rajouter plus de quantité pour un panier
        if(!empty($cart[$id])){
             
            $cart[$id]++;
        }else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    /************************* */

    public function get()
    {
        return $this->session->get('cart');
    }

    /************************** */

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id){

        $cart = $this->session->get('cart', []);

        unset($cart[$id]);
        // pour supprimer lar cards direct dans le panier
        return $this->session->set('cart', $cart);
    }

    // decrease = diminuer
    public function decrease($id){

        $cart = $this->session->get('cart', []);

        if($cart[$id] >1){
            //retirer une quantité
            $cart[$id]--;
        }else {
            //ajouter une quantité
            unset($cart[$id]);
        }
        return $this->session->set('cart', $cart);

    }

    /***************************c le meca du panier */
    public function getFull()
    {
        $cartComplete = [];

        if ($this->get()){ 
        foreach($this->get() as $id => $quantity){
            
             $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);
           
            if (!$product_object){

                $this->delete($id);
                continue;
            }

             $cartComplete[] = [
                'product' => $product_object,
                'quantity' => $quantity
            ];
        } 

        }

        return $cartComplete;
    }
}
