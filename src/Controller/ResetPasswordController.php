<?php

namespace App\Controller;

use App\CustomClass\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/forgotten-password", name="reset_password")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $request->get('email')]);

            if ($user) {
                // step 1 : Register in db the reset_password query with user, token and createdAt
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new \DateTime());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                // step 2 : send an email to the user with a link allowing him to update his password

                $url = $this->generateUrl('update_password', [
                    'token' => $reset_password->getToken()
                ]);
                $content = "Hello " . $user->getLastname() . "<br />You have asked to reset your password on the website Eshoptimal. <br /><br />";
                $content .= "Thanks for clicking on the following link to <a href='". $url ."'>update your password.</a>";

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname() . ' ' . $user->getLastname(), 'Reset your password on Eshoptimal', $content);

                $this->addFlash('notice', "You will recieve in a few seconds an email to reset your password.");

            } else {
                $this->addFlash('notice', "This email adress doesn't exist.");
            }
        }

        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("/modify-my-password/{token}", name="update_password")
     */
    public function update(Request $request, UserPasswordEncoderInterface $encoder, $token): Response
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if (!$reset_password) {
            return $this->redirectToRoute('reset_password');
        }

        // check if createdAt = now - 3h (exemple)
        $now = new \DateTime();

        if ($now > $reset_password->getCreatedAt()->modify('+ 3 hour')) {
            $this->addFlash('notice', 'Your password modification request has expired. Please make a new request.');
            return $this->redirectToRoute('reset_password');
        }

        // return a view with password and and confirm your password
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_pwd = $form->get('new_password')->getData();

            // Encoding passwords
            $password = $encoder->encodePassword($reset_password->getUser(), $new_pwd);

            $reset_password->getUser()->setPassword($password);

            $this->entityManager->flush();

            $this->addFlash('notice', 'Your password has been updated successfully.');
            return $this->redirectToRoute('login');
        }

        return $this->render('reset_password/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
