<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 04/12/2018
 * Time: 11:44
 */

namespace App\Controller;

use App\Form\Type\ContactType;
use App\Model\Contact;
use App\Service\ContactMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route(methods={"GET","POST"})
     */
    public function index(Request $request, ContactMailer $contactMailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMailer->sendContactEmail($contact);

            $this->addFlash('success', 'Message de contact envoyer avec succès !');
            return $this->redirectToRoute('app_contact_index');
        }
        return $this->render('contact/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}