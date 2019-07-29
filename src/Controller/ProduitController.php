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
    public function show(Produit $produit)
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit
        ]);
    }


}
