<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProduitRepository;
use App\Entity\Panier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use App\Form\PanierType;

class PanierController extends AbstractController
{
    private $panier_repository;

    public function __construct(PanierRepository $panier_repository) {
        $this->panier_repository = $panier_repository;
    }


    /**
     * @Route("/paniers", name="panier_index", methods={"GET"})
     *//*
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }
*/
    
    /**
     * @Route("paniers/{id}", name="panier_show", methods={"GET"})
     *//*
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }
    */
    /**
     * @Route("/mon_panier", name="mon_panier")
     */
    public function mon_panier()
    {
        $user = $this->getUser();
        $paniers = $user->getPaniers();
        return $this->render( 'panier/panier.html.twig', [
            'user' => $user,
            'paniers' => $paniers,
            'titre' => 'Mon Panier'
        ]);
    }


    public function mini()
    {
        $user = $this->getUser();
        $paniers = $user->getPaniers();
        return $this->render('panier/mini_panier.html.twig', [
            'user'    => $user,
            'paniers' => $paniers,
        ]);
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/ajout_panier", name="ajout_panier", methods={"POST"})
     */
    public function ajouter(Request $request, ProduitRepository $produit_repository, PanierRepository $panier_repository)
    {
        $utilisateur = $this->getUser();
        // $quantite = $request->request->get('quantite');
        $ajout_quantite = $request->request->get('quantite');
        $article = $produit_repository->find($request->request->get('id'));
        $prix = $article->getPrix();
        $ajout_montant = $prix * $ajout_quantite;
        $date = new \DateTime();

        $em = $this->getDoctrine()->getManager();

        $panier = $panier_repository->findPanierByClientAndProduit($utilisateur, $article);

        if (isset($panier))
        {
            $quantite = $panier->getQuantite();
            $panier->setQuantite($quantite + $ajout_quantite);
            $montant = $panier->getMontant();
            $panier->setMontant($montant + $ajout_montant);
            $panier->setUpdatedAt($date);

            $em->flush();
        }
        else
        {
            $panier = new Panier();
            $panier->setClient($utilisateur);
            $panier->setCreatedAt($date);
            $panier->setProduit($article);
            $panier->setQuantite($ajout_quantite);
            $panier->setMontant($ajout_montant);
            $panier->setPrixUnite($prix);

            $em->persist($panier);
            $em->flush();
        }
        $this->addFlash('success', 'Votre panier a bien été mis ajour.');
        return $this->redirectToRoute('mon_panier'); //Re-diriger vers où??
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/vider_panier", name="vider_panier")
     */
    public function vider(Request $request, PanierRepository $panier_repository)
    {
        $user = $this->getUser();        //  ??
        
        $em = $this->getDoctrine()->getManager();
        
        $paniers = $user->getPaniers();
        // $paniers = $panier_repository->findAllByClient($user);
        foreach ($paniers as $panier) {
            $em->remove($panier);
            $em->flush();
        }

        $this->addFlash('success', 'Votre panier a bien été vidé.');

        return $this->redirectToRoute('home'); //Re-diriger vers où??
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/supprimer_panier", name="supprimer_panier")
     */
    public function supprimer(Request $request, PanierRepository $panier_repository)
    {
        $panier = $panier_repository->find($request->request->get('panier_id'));
        $propietaire = $panier->getClient();
        $utilisateur = $this->getUser();
        if (!($utilisateur === $propietaire))
        {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé a supprimer ce panier.');
            $this->redirectToRoute('panier');
        }
        $em = $this->getDoctrine()->getManager();
        
        $em->remove($panier);
        $em->flush();
        

        $this->addFlash('success', 'Ce produit a bien été spprimé de votre panier.');

        return $this->redirectToRoute('mon_panier'); //Re-diriger vers où??
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/modifier_panier", name="modifier_panier", methods={"POST"})
     */
    public function modifier(Request $request, PanierRepository $panier_repository)
    {
        $panier = $panier_repository->find($request->request->get('panier_id'));
        $date = new \DateTime();
        $prix = $panier->getPrixUnite();
        $quantite = $request->request->get('quantite');
        $montant = $prix * $quantite;
        $panier->setQuantite( $quantite);
        $panier->setMontant($montant);
        $panier->setUpdatedAt($date);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('mon_panier'); //Re-diriger vers où??
    }

    
}
