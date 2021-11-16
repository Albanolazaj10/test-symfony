<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/reg", name="reg")
     */
    public function reg(Request $request, UserPasswordHasherInterface  $passwordHasher): Response
    {
        $regform = $this->createFormBuilder()
        ->add('username', TextType::class,[
            'label' => 'Username'])
        ->add('password', RepeatedType::class,[
            'type' =>PasswordType::class,
            'required' => true,
            'first_options' => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password']
        ])
        
        ->add('registration', SubmitType::class)
        ->getForm()
        ;

        $regform->handleRequest($request);

        if ($regform->isSubmitted()) {
            $input = $regform->getData();
            
            $user = new User();
            $user->setUsername($input['username']);

           
            // $hashedPassword->$passwordHasher->hash($user, $input['password']);
            // $user->setPassword($hashedPassword); 
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $input['password']
            );
            $user->setPassword($hashedPassword);
            

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('registration/index.html.twig', [
            'regform' => $regform->createView()
        ]);
    }


}
