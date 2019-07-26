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
        $produits = $produit_repository->findByPrice($montant, 'DESC');
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



    //Cette route ne sert à rien, efface-la
    /**
     * @Route("/produits/{cat}", name="produits_par_cat", methods={"GET", "POST"})
     */
    public function produits_cat(ProduitRepository $produit_repository, CategorieRepository $category_repository, $cat)
    {
        $categorie = $category_repository->findOneBy(['nom' => $cat]);
        $produits = $produit_repository->findBy(['categorie' => $categorie]);
        return $this->render('produit/produit_categorie.html.twig', [
            'produits' => $produits
        ]);
    }
    // Est-ce que ces deux routes auront du conflit  ?? On change la route à /produit/categorie/{cat} et /produit/label/{tag} ??
    /**
     * @Route("/produits/{tag}", name="produits_par_tag", methods={"GET", "POST"})
     */
    public function produits_tag(ProduitRepository $produit_repository, TagRepository $tag_repository, $tag)
    {
        $label = $tag_repository->findOneBy(['nom' => $tag]);
        $produits = $produit_repository->findBy(['tags' => $label]); // comment faire la recherche sur un array  ???
        return $this->render('produit/produit_tag.html.twig', [ // Pas besoin, c'est déjà fait dans Tags. Cette route ne sert à rien, efface-la
            'produits' => $produits
        ]);
    }


}
