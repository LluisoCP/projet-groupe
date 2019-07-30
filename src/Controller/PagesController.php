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
        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route("/about", name="about", methods={"GET"})
     */
    public function about()
    {
        return $this->render('pages/about.html.twig', [
            'titre' => 'Qui sommes nous'
        ]);
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
     * @Route("/mentions_legales", name="mentions_legales", methods={"GET"})
     */
    public function mentions()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Mentions Légales'
        ]);
    }

    /**
     * @Route("/conditions_vente", name="conditions_vente", methods={"GET"})
     */
    public function conditions_vente()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Conditions Générales de Vente'
        ]);
    }


    /**
     * @Route("/conditions_utilisation", name="conditions_utilisation", methods={"GET"})
     */
    public function conditions_uitlisation()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Conditions Générales d\'Utilisation'
        ]);
    }

    /**
     * @Route("/service_client", name="service_client", methods={"GET"})
     */
    public function service_client()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Sevices Client'
        ]);
    }

    /**
     * @Route("/service_apres_vente", name="service_apres_vente", methods={"GET"})
     */
    public function service_apres_vente()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Services Après Vente'
        ]);
    }

    /**
     * @Route("/services", name="services", methods={"GET"})
     */
    public function services()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Nos Services'
        ]);
    }

    /**
     * @Route("/service_technique", name="service_technique", methods={"GET"})
     */
    public function service_technique()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Services Techniques'
        ]);
    }

    /**
     * @Route("/service_presse", name="service_presse", methods={"GET"})
     */
    public function service_presse()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Services Presse'
        ]);
    }

    /**
     * @Route("/nos_valeurs", name="nos_valeurs", methods={"GET"})
     */
    public function nos_valeurs()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Nos Valuers'
        ]);
    }

    /**
     * @Route("/recrutement", name="recrutement", methods={"GET"})
     */
    public function recrutement()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Processus de Recrutement'
        ]);
    }

    /**
     * @Route("/fidelite", name="fidelite", methods={"GET"})
     */
    public function fidelite()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Notre Programme de Fidelité'
        ]);
    }

    /**
     * @Route("/cookies", name="cookies", methods={"GET"})
     */
    public function cookies()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Notre Politique de Cookies'
        ]);
    }

    /**
     * @Route("/gerer_cookies", name="gerer_cookies", methods={"GET"})
     */
    public function gerer_cookies()
    {
        return $this->render('pages/mentions.html.twig', [
            'titre' => 'Gérer vos Cookies'
        ]);
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


}
