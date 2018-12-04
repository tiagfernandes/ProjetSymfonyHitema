<?php
/**
 * Created by PhpStorm.
 * User: Tiago
 * Date: 03/12/2018
 * Time: 10:11
 */

namespace App\Service;


use App\Entity\Purchase;
use App\Entity\User;
use App\Model\Contact;
use Twig\Environment;

class ContactMailer
{

    private $twig;

    private $mailer;

    private $emailAdmin;

    private $emailFrom;

    public function __construct(Environment $twig, \Swift_Mailer $mailer, string $emailAdmin)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->emailAdmin = $emailAdmin;
    }

    public function sendContactEmail(Contact $contact)
    {

        $message = new \Swift_Message();

        $message
            ->setTo($this->emailAdmin)
            ->setFrom($contact->getEmail())
            ->setSubject($contact->getSubject())
            ->setBody($contact->getMessage());

        $bodyHtml = $this->twig->render('contact/email.html.twig', array(
            'contact' => $contact,
        ));

        $message->addPart($bodyHtml, 'text/html');

        return $this->mailer->send($message);

    }

    public function sendRegistrationEmail(User $user)
    {

        $message = new \Swift_Message();

        $message
            ->setTo($user->getEmail())
            ->setFrom($this->emailAdmin)
            ->setSubject('Bienvenue chez Netflox !')
            ->setBody('Félicitation, vous êtes incrit chez nous');

        return $this->mailer->send($message);

    }

    public function sendConfirmPurchase(Purchase $purchase)
    {

        $message = new \Swift_Message();

        $message
            ->setTo($purchase->getUser()->getEmail())
            ->setFrom($this->emailAdmin)
            ->setSubject('Validation payement')
            ->setBody('Votre commande pour la vidéo ' . $purchase->getVideo()->getName() . 'à bien été confirmer');

        return $this->mailer->send($message);

    }
}