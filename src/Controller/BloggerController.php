<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BloggerController extends AbstractController
{
    /**
     * @Route("/blogger", name="blogger")
     */
    public function index()
    {
        return $this->render('blogger/index.html.twig', [
            'controller_name' => 'BloggerController',
        ]);
    }
}
