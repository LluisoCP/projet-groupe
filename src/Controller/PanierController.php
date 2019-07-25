<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PanierRepository;

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
        $paniers = $this->getUser()->getPaniers;
        return $this->render('panier/panier.html.twig', [
            'paniers' => $paniers,
        ]);
    }

    public function mini()
    {
        $paniers = $this->getUser()->getPaniers;
        return $this->render('panier/mini_panier.html.twig', [
            'paniers' => $paniers,
        ]);
    }

    
}
