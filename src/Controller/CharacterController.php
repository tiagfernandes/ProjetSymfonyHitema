<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 30/11/2018
 * Time: 14:10
 */

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Video;
use App\Form\Type\CharacterType;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/character")
 */
class CharacterController extends Controller
{
    /**
     * @Route("/list")
     */
    public function list(Request $request, PaginatorInterface $paginator)
    {

        $search = $request->query->get('search');
        $em = $this->getDoctrine()->getManager();

        // Get some repository of data, in our case we have an Appointments entity
        $characterRepository = $em->getRepository(Character::class);

        $characterQuery = $characterRepository->createQueryBuilder('c');

        //If is a search
        if ($search) {
            $characterQuery = $characterRepository->findBySearch($search);
        }

        $allCharactersQuery = $characterQuery->getQuery();

        // Paginate the results of the query
        $pagination = $paginator->paginate(
        // Doctrine Query, not results
            $allCharactersQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            6
        );

        return $this->render('character/index.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Route("/create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request, FileUploader $fileUploader)
    {
        $character = new Character();

        $form = $this->createForm(CharacterType::class, $character);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $character->getRowImage();
            $fileName = $fileUploader->upload($file);

            $character->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($character);
            $em->flush();

            return $this->redirectToRoute('app_character_list');
        }

        return $this->render('character/form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{slug}/delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public
    function delete(Request $request, Character $character, FileUploader $fileUploader)
    {
        $token = $request->query->get('token');

        if (!$this->isCsrfTokenValid('DELETE_CHARACTER', $token)) {
            return $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($character);
        $em->flush();

        $fileUploader->removeFile($character->getImage());

        $this->addFlash('success', 'Personne supprimé avec succès.');

        return $this->redirectToRoute('app_character_list');
    }

    /**
     * @Route("/{slug}/update")
     * @IsGranted("ROLE_ADMIN")
     */
    public
    function update(Request $request, FileUploader $fileUploader, Character $character)
    {
        $form = $this->createForm(CharacterType::class, $character, array('required_image' => false));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($character->getRowImage() != null && $character->getRowImage() != $character->getImage()) {
                $file = $character->getRowImage();
                $fileName = $fileUploader->upload($file);

                $character->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($character);
            $em->flush();

            return $this->redirectToRoute('app_character_list');

        }
        return $this->render('character/form.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("/{slug}")
     */
    public function characterBySlug(Character $character)
    {
        return $this->render('character/detail.html.twig', array('character' => $character));
    }
}