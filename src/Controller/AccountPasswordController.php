<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->entityManager = $entityManger;
    }

    #[Route('/compte/modifier-mon-mot-de-passe', name: 'account_password')]
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        // pour voir si tout est prêt pour la modif
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $old_pwd = $form->get('old_password')->getData();

            if($encoder->isPasswordValid($user, $old_pwd)){

                $new_pwd = $form->get('new_password')->getData();

                $password = $encoder->encodePassword($user, $new_pwd);

                $user->setPassword($password);

                //mettre a jour en base

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $notification = 'Bravo votre mot de passe à bine été mis à jour';
    
            }
            
            else{
                $notification = "Votre mot de passe actuel est incorrect.";
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
