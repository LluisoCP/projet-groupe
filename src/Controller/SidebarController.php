<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Repository\TagRepository;

class SidebarController extends AbstractController
{
    
    public function show(CategorieRepository $category_repository, TagRepository $tag_repository)
    {
        $categories = $category_repository->findAll();
        $tags = $tag_repository->findAll();
        return $this->render('sidebar/sidebar.html.twig', [
            'categories' => $categories,
            'tags'       => $tags
        ]);
    }
}
