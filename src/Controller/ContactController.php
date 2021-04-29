<?php

namespace App\Controller;

use App\CustomClass\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact-us", name="contact")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Thanks for contacting us. Our team will respond as soon as possible.');

            $mail = new Mail();
            $mail->send('youpijoedjopijoe@hotmail.fr', 'Eshoptimal', 'Message from ' . $form->getData()['firstname'] . ' ' . $form->getData()['lastname'] . ' (' . $form->getData()['email'] . ')', $form->getData()['content']);
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

