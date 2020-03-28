<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    
    public function index()
    {
        return $this->render('global/acceuill.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    
    public function register(Request $req, EntityManagerInterface $man, UserPasswordEncoderInterface $encode)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $passCrypt = $encode->encodePassword($user,$user->getPassword());
            $user->setPassword($passCrypt);
            $user->setRoles('ROLE_USER');
            $man->persist($user);
            $man->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('global/register.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $util){

        return $this->render('global/login.html.twig',[
            "lastUserName" =>$util->getLastUsername(),
            "error"=>$util->getLastAuthenticationError()
        ]);
    }

       /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

        return $this->render('global/login.html.twig');
    }

}
