<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 27/11/2018
 * Time: 14:33
 */

namespace App\Controller;

use App\Entity\Type;
use App\Entity\Video;
use App\Form\Type\VideoType;
use App\Service\FileUploader;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/video")
 */
class VideoController extends AbstractController
{
    /**
     * @Route("/create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request, FileUploader $fileUploader)
    {
        $video = new Video();

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($video->getRowImage()) {

                $file = $video->getRowImage();
                $fileName = $fileUploader->upload($file);

                $video->setImage($fileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('app_video_listvideo');

        }
        return $this->render('video/form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{slug}/update")
     * @IsGranted("ROLE_ADMIN")
     */
    public
    function update(Request $request, FileUploader $fileUploader, Video $video)
    {
        $form = $this->createForm(VideoType::class, $video, array('required_image' => false));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($video->getRowImage() != null && $video->getRowImage() != $video->getImage()) {
                $file = $video->getRowImage();
                $fileName = $fileUploader->upload($file);

                $video->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('app_video_listvideo');

        }
        return $this->render('video/form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{slug}/delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public
    function delete(Request $request, Video $video, FileUploader $fileUploader)
    {
        $token = $request->query->get('token');

        if (!$this->isCsrfTokenValid('DELETE_VIDEO', $token)) {
            return $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();

        $fileUploader->removeFile($video->getImage());

        $this->addFlash('success', 'Vidéo supprimé avec succès.');

        return $this->redirectToRoute('app_video_listvideo');
    }


    /**
     * @Route("/list")
     */
    public function listVideo(Request $request, PaginatorInterface $paginator)
    {
        $search = $request->query->get('search');
        $em = $this->getDoctrine()->getManager();

        // Get some repository of data, in our case we have an Appointments entity
        $videoRepository = $em->getRepository(Video::class);

        $videoQuery = $videoRepository->createQueryBuilder('v');

        //If is a search
        if ($search) {
            $videoQuery = $videoRepository->findBySearch($search);
        }

        $allVideosQuery = $videoQuery->getQuery();

        // Paginate the results of the query
        $pagination = $paginator->paginate(
        // Doctrine Query, not results
            $allVideosQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            6
        );

        return $this->render('video/index.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Route("/{slug}")
     */
    public
    function videoBySlug(Video $video)
    {
        return $this->render('video/detail.html.twig', array('video' => $video));
    }

    /**
     * @Route("/type/{name}")
     */
    public function listVideoByType(Request $request, Type $type, PaginatorInterface $paginator)
    {

        $search = $request->query->get('search');
        $em = $this->getDoctrine()->getManager();

        // Get some repository of data, in our case we have an Appointments entity
        $videoRepository = $em->getRepository(Video::class);

        //If is a search
        $videoQuery = $videoRepository->findBySearchAndType($search, $type);


        $allVideosQuery = $videoQuery->getQuery();
        // Paginate the results of the query
        $pagination = $paginator->paginate(
        // Doctrine Query, not results
            $allVideosQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            6
        );

        return $this->render('video/index.html.twig', array('pagination' => $pagination, 'type' => $type));

    }
}