<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Entity\Message;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function index(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            // 1. Rediect:
            return $this->redirectToRoute('home');
            /**
            * 2. Display same page: (sans handleRequest())
            * unset($form);
            * unset($deet);
            * $deet = new Deet();
            * $form = $this->createForm(DeetType::class, $deet);
             */
        }
    

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
