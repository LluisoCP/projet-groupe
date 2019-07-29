<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Produit;
/**
 * @isGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/index", name="admin", methods={"GET"})
     */
    public function index(ClientRepository $client_repository, ProduitRepository $produit_repository, PanierRepository $panier_repository)
    {
        $clients = $client_repository->findAll();
        $produits = $produit_repository->findAll();
        $paniers = $panier_repository->findAll();

        return $this->render('admin/index.html.twig', [
            'clients' => $clients,
            'produits' => $produits,
            'paniers' => $paniers
        ]);
    }

    /**
     * @Route("/clients", name="admin_clients", methods={"GET"})
     */
    public function clients(ClientRepository $client_repository)
    {
        $clients = $client_repository->findAll();
        return $this->render('admin/clients.html.twig', [
            'clients' => $clients,
        ]);

    }
    /**
     * @Route("/produits", name="admin_produits", methods={"GET"})
     */
    public function produits(ProduitRepository $produit_repository)
    {
        $produits = $produit_repository->findAll();
        return $this->render('admin/produits.html.twig', [
            'produits' => $produits,
        ]);

    }
    /**
     * @Route("/paniers", name="admin_paniers", methods={"GET"})
     */
    public function paniers(PanierRepository $panier_repository)
    {
        $paniers = $panier_repository->findAll();
        return $this->render('admin/paniers.html.twig', [
            'paniers' => $paniers,
        ]);

    }
    /**
     * @Route("/ajout_produit", name="admin_ajout_produits", methods={"GET", "POST"})
     */
    public function ajout_produit(Request $request)
    {
        $product = new Produit();
        return $this->render('admin/produits.html.twig', [
            'produits' => $produits,
        ]);

    }
}
