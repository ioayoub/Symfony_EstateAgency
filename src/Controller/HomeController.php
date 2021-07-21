<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\PropertyRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(PropertyRepository $repo): Response
    {
        $properties = $repo->findLatest();
        dump($properties);

        return $this->render('home/index.html.twig', [
            'properties' => $properties

        ]);
    }
}
