<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/inscription', name: 'register')]

    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;
        $user = new User(); 

        $form = $this->createForm(RegisterType::class, $user);

        // pour savoir si le formulaire est valide et envoie en base 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 

            // recup les data
            $user = $form->getData();

            // voir le user n'est pas déjà enregistrer en base 
            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if(!$search_email){
                // encoder mdp
                $password = $encoder->encodePassword($user,$user->getPassword());
                $user->setPassword($password);

                // pour enregistrer et mettre a jour en base
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $mail = new Mail();
                $content = "Bojour".$user->getFirstname()."<br />Si vous êtes c'est que vous voulez devenir un champion alors GO !";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bonjour Champion', $content);

                $notification = "Inscription valider !";
            }else {
                $notification = "L'email existe déjà";
            }     
        }

        return $this->render('register/index.html.twig', [

            'form' => $form->createView() ,
            'notification' => $notification
        ]);
    }
}
