<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Entity\Produit;
use App\Repository\CategorieRepository;

class PagesController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index()
    {
        return $this->render('pages/home.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }

    /**
     * @Route("/about", name="about", methods={"GET"})
     */
    public function about()
    {
        return $this->render('pages/about.html.twig');
    }

    /**
     * @Route("/", name="home")
     */
    public function produits(ProduitRepository $produit, CategorieRepository $cat)
    {
        // on récupère le repository des produits
        $liste = $produit->findAll();
        $listeCat = $cat->findAll();
        return $this->render(
            'pages/home.html.twig',
            [
                'title' => "Nos produits",
                'liste' => $liste,
                'listeCat' => $listeCat
            ]
        );
    }

    /**
     * @Route("/home/{libelle}", name="trouverNom")
     */
    public function trouverNom($nom, ProduitRepository $produit)
    {
        // on récupère le repository des produits
        $liste = $produit->findBy(['nom' => $nom]);
        return $this->render(
            'public/produit.html.twig',
            [
                'title' => "Nos produits",
                'liste' => $liste
            ]
        );
    }

    /**
     * @Route("/home/{cat}", name="trouverCat")
     */
    public function trouverCat($cat, ProduitRepository $produit)
    {
        // on récupère le repository des produits
        $liste = $produit->findBy(['categorie_id' => $cat]);
        return $this->render(
            'public/produit.html.twig',
            [
                'title' => "Nos produits",
                'liste' => $liste
            ]
        );
    }

    /**
     * @Route("/home/{prix}", name="trouverPrix")
     */
    public function trouverPrix($prix, ProduitRepository $produit)
    {
        // on récupère le repository des produits
        $liste = $produit->findBy(['categorie_id' => $prix]);
        return $this->render(
            'public/produit.html.twig',
            [
                'title' => "Nos produits",
                'liste' => $liste
            ]
        );
    }

}
