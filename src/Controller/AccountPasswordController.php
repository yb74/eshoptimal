<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    /**
     * AccountPasswordController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/modify-password", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $previous_password = $form->get('previous_password')->getData();

            if ($encoder->isPasswordValid($user, $previous_password)) {
                $new_password = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $new_password);

                $user->setPassword($password);

                $this->entityManager->persist($user); // not useful here cos we just update the pwd
                $this->entityManager->flush();
                $notification = "Your password has been modified";
            } else {
                $notification = "Your current password is not correct";
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
