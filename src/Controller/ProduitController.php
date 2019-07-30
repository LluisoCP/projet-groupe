<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\TagRepository;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ProduitType;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits", methods={"GET", "POST"})
     */
    public function index(ProduitRepository $produit_repository)
    {
        $produits = $produit_repository->findAll();
        return $this->render('produit/tous.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/results", name="results")
     */
    public function results(Request $request, ProduitRepository $produit_repository, SerializerInterface $serializer)
    {
        $price = $request->query->get('price');
        $order = $request->query->get('order');
        $produits = $produit_repository->findByPrice($price, $order);

        $jsonProduits = $serializer->serialize($produits, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonProduits, 200, ['Content-Type' => 'application/json']);
    }


    /**
     * @Route("/produit/{id}", name="produit", methods={"GET", "POST"})
     */
    public function show($id, ProduitRepository $produit)
    {
        $liste = $produit->findBy(['id' => $id]);
        return $this->render('produit/show.html.twig', [
            'title' => "Nos produits",
            'liste' => $liste
        ]);
    }

    /**
     * @Route("/createProduit", name="createProduit", methods={"GET", "POST"})
     */
    public function createProduit(Request $request)
    {
        $message = new Produit();
        $form = $this->createForm(ProduitType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            // 1. Rediect:
            return $this->redirectToRoute('home');
            /**
             * 2. Display same page: (sans handleRequest())
             * unset($form);
             * unset($deet);
             * $deet = new Deet();
             * $form = $this->createForm(DeetType::class, $deet);
             */
        }


        return $this->render('produit/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}
