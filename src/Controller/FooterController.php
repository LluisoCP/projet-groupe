<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;

class FooterController extends AbstractController
{
    /**
     * @Route("/footer", name="footer")
     */
    public function index(CategorieRepository $categorie_repository)
    {
        $categories = $categorie_repository->findAll();
        return $this->render('footer/footer.html.twig', [
            'categories' => $categories,
        ]);
    }
}
