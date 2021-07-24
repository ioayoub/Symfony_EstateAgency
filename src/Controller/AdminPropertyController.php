<?php

namespace App\Controller;


use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{

    public function __construct(PropertyRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin_property_index")
     */
    public function index(): Response
    {
        $properties = $this->repo->findAll();


        return $this->render('admin/property/index.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'properties' => $properties
        ]);
    }
    /**
     * @Route("/admin/property/edit/{id}", name="admin_property_edit", methods={"GET", "POST"})
     */

    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Property updated successfully');
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'property' => $property,
            'form' => $form->createView()

        ]);
    }
    /**
     * @Route("/admin/property/new", name="admin_property_new")
     */
    public function new(Request $request)
    {

        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Property created successfully');
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/property/new.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'property' => $property,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/admin/property/delete/{id}", name="admin_property_delete")
     */

    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getid(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Property deleted successfully');
        }
        return $this->redirectToRoute('admin_property_index');
    }
}
