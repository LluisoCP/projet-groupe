<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\TagRepository;
use App\Entity\Produit;

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

    //Essay pour tester la fonction findByPrice, elle marche. 
    /**
     * @Route("/produit/prix/{montant}", name="p_par_prix")
     */
    public function per_prix(ProduitRepository $produit_repository , $montant)
    {
        $produits = $produit_repository->findByPrice($montant, 'DESC'); //C'est 'ASC' par défaut
        return $this->render('produit/tous.html.twig', [
            'produits' => $produits
        ]);
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
