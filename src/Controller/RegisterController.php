<?php

namespace App\Controller;

use App\CustomClass\Mail;
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
        $notification = null;

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$search_email) {
                $plainPassword = $user->getPassword();
                $encoded = $encoder->encodePassword($user, $plainPassword);

                $user->setPassword($encoded);

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $mail = new Mail();
                $content = "Hello " . $user->getFirstname() . "<br /> Welcome to The new Eshop which sells the best products at the cheapest price ! <br /> You can now add products to your cart and buy them.";
                $mail->send($user->getEmail(), $user->getFirstname(), "Welcome to Eshoptimal", $content);

                $notification = "Your registration has been successfully completed. You can now log in";
            } else {
                $notification = "The email you provided already exists";
            }
        }

        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
