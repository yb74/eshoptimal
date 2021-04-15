<?php

namespace App\Controller;

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

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        // $userYounes = $this->getDoctrine()->getRepository(User::class)->findBy(['roles' => "admin"]);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);

            $user->setPassword($encoded);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'registerForm' => $form->createView()
        ]);
    }
}
