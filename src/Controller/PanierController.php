<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends AbstractController
{
    private $panier_repository;

    public function __construct(PanierRepository $panier_repository) {
        $this->panier_repository = $panier_repository;
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function index()
    {
        $paniers = $this->getUser()->getPaniers();
        // dump(empty($paniers));
        // dd($paniers);
        return $this->render('panier/panier.html.twig', [
            'paniers'   => $paniers,
            'titre'     => 'Mon Panier'
        ]);
    }

    public function mini()
    {
        $paniers = $this->getUser()->getPaniers();
        return $this->render('panier/mini_panier.html.twig', [
            'paniers' => $paniers,
        ]);
    }

    /**
     * @Route("/vider_panier", name="vider_panier")
     */
    public function vider(Request $request)
    {
        $user = $request->getUser();        //  ??
    }

    
}
