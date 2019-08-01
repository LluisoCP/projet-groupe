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
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Panier;
use App\Entity\Client;
use App\Form\PanierType;
use App\Form\ProduitType;
use App\Form\ClientType;

/**
 * @isGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /** HOME ADMIN  */

    
    /**
     * @Route("/", name="admin", methods={"GET"})
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


    /** CLIENT  */

    /**
     * @Route("/clients", name="admin_clients", methods={"GET"})
     */
    public function clients(ClientRepository $client_repository)
    {
        $clients = $client_repository->findAll();
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);

    }

    /**
     * @Route("/clients/{id}", name="admin_client", methods={"GET"})
     */
    public function client(ClientRepository $client_repository, $id)
    {
        $client = $client_repository->find($id);
        return $this->render('client/show.html.twig', [
            'client' => $client,
            'nom' => $client->getNom()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit_client(Request $request, ClientRepository $client_repository, $id): Response
    {
        $client = $client_repository->find($id);
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'nom' => $client->getNom(),
            'form' => $form->createView(),
        ]);
    }

    /**  PRODUIT */

    /**
     * @Route("/produits", name="admin_produits", methods={"GET"})
     */
    public function produits(ProduitRepository $produit_repository)
    {
        $produits = $produit_repository->findAll();
        return $this->render('produit/produits.html.twig', [
            'produits' => $produits,
        ]);

    }

    /**
     * @Route("/produits/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produits/{id}", name="admin_produit", methods={"GET"})
     */
    public function produit(ProduitRepository $produit_repository, $id)
    {
        $produit = $produit_repository->find($id);
        return $this->render('produit/produit.html.twig', [
            'produit' => $produit,
            'nom'     => $produit->getNom()
        ]);
    }


    /**
     * @Route("/{id}", name="produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_produits');
    }




    /** PANIER */
    /**
     * @Route("/paniers", name="admin_paniers", methods={"GET"})
     */
    public function paniers(PanierRepository $panier_repository) :Response
    {
        $paniers = $panier_repository->findAll();
        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
        ]);

    }

    /**
     * @Route("panier/new", name="panier_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('admin_paniers');
        }

        return $this->render('client/new.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/paniers/{id}/edit", name="panier_edit", methods={"GET","POST"})
     */
    public function edit_panier(Request $request, PanierRepository $panier_repository, $id)
    {
        $panier = $panier_repository->find($id);
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('admin_paniers');
            }

        return $this->render('panier/edit.html.twig', [
            'panier' => $panier,
            'nom' => $panier-> getId(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/paniers/{id}", name="panier_show", methods={"GET"})
     */
    public function panier( PanierRepository $panier_repository, $id): Response
    {
        $panier = $panier_repository->find($id);
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }


    /**
     * @Route("/panier/{id}", name="panier_delete", methods={"DELETE"})
     */
    public function delete_panier(Request $request, PanierRepository $panier_repository, $id): Response
    {
        $panier = $panier_repository->find($id);
        if ($this->isCsrfTokenValid('delete' . $panier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_paniers');
    }
    /**
     * @Route("/ajout_produit", name="admin_ajout_produits", methods={"GET", "POST"})
     */
    // public function ajout_produit(Request $request)
    // {
    //     $product = new Produit();
    //     return $this->render('admin/produits.html.twig', [
    //         'produits' => $produits,
    //     ]);

    // }
}
