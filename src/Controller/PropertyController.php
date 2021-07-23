<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    public function __construct(PropertyRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property_index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
            $this->repo->findAllVisibileQuery($search),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/{slug}/{id}", name="property_show", requirements={"slug" : "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}
