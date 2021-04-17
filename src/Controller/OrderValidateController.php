<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Classe\Cart;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class OrderValidateController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
    }

    #[Route('/commande/merci/{stripeSessionId}', name: 'order_validate')]
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        // si le user n'est pas sur sa page alors il sera rediriger
        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        if($order->getState() == 0 ){
            // vider la session Cart
            $cart->remove();
            // pour savoir si notre commande a bien été payer
            $order->setState(1);
            $this->entityManager->flush();

            // envoyer un mail pour confirm <command>
            $mail = new Mail();
            $content = "Bonjour ".$order->getUser()->getFirstname()."<br/>Merci pour votre commande.<br><br/>Lorem ipsum dolor sit amet, consectetur 
            adipisicing elit. Aperiam expedita fugiat ipsa magnam mollitia optio voluptas! 
            Alias, aliquid dicta ducimus exercitationem facilis,
             incidunt magni, minus natus nihil odio quos sunt?";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 
            'Votre commande La Boutique Française est bien validée.', $content);
        }
        
        return $this->render('order_validate/index.html.twig',[
            'order' => $order
            // pour afficher des infos sur la commande aux user
        ]);
    }
}
