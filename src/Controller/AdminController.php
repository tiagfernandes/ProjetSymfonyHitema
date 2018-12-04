<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 28/11/2018
 * Time: 10:03
 */
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/")
     */
    public function index(Request $request)
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

}