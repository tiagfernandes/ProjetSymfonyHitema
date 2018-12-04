<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 03/12/2018
 * Time: 16:40
 */

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\Video;
use App\Form\Type\CreditCardType;
use App\Model\CreditCard;
use App\Service\ContactMailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/purchase")
 */
class PurchaseController extends AbstractController
{

    /**
     * @Route("/{slug}/preview")
     */
    public function preview(Video $video)
    {
        //Afficher le recap et le prix
    }

    /**
     * @Route("/{slug}/payment")
     * @IsGranted("ROLE_USER")
     */
    public function payment(Request $request, Video $video, ContactMailer $contactMailer)
    {
        $referer = $request->headers->get('referer');
        foreach ($this->getUser()->getPurchases() as $purchase){
            if($purchase->getVideo() == $video){
                $this->addFlash('warning', 'Vous avez déjà cette vidéo');
                return $this->redirect($referer);
            }
        }

        if ($video->getRequiredAge()) {
            if ($video->getRequiredAge() > $this->getUser()->getAge()) {
                $this->addFlash(
                    'danger',
                    'Vous n\'avez pas l\'âge requis pour acheter cette vidéo !'
                );
                return $this->redirect($referer);
            }
        }
        $creditCard = new CreditCard();
        $form = $this->createForm(CreditCardType::class, $creditCard);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $purchase = new Purchase();

            $purchase->setVideo($video)->setUser($this->getUser())->setPrice($video->getPrice())->setIsPaid(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($purchase);
            $em->flush();

            $contactMailer->sendConfirmPurchase($purchase);
            $this->addFlash('success', 'Votre vidéo à bien été commandée !');

            return $this->redirectToRoute('app_purchase_list');

        }
        return $this->render('purchase/form.html.twig', array('form' => $form->createView(), 'video' => $video));
    }

    /**
     * @Route("/list")
     * @IsGranted("ROLE_USER")
     */
    public function list()
    {
        $em = $this->getDoctrine()->getManager();
        $purchases = $em->getRepository(Purchase::class)->findBy(array('user' => $this->getUser()));

        return $this->render('purchase/index.html.twig', array('purchases' => $purchases));
    }
}