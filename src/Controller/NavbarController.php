<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
class NavbarController extends AbstractController
{
    
    public function show(AuthorizationCheckerInterface $auth)
    {
        if ($auth->isGranted("ROLE_ADMIN"))
        {
            $liens = [
                // ['href' => 'clients',       'lib' => 'Clients',         'icon' => 'fas fa-user'],
                // ['href' => 'paniers',    'lib' => 'Paniers',      'icon' => 'fas fa-shopping-basquet'],
                ['href' => 'createProduit', 'lib' => 'Ajout Produit',   'icon' => 'fas fa-plus-circle'],
                // ['href' => 'ajout_tag', 'lib' => 'Ajout Etiquette',   'icon' => 'fas fa-plus-circle'],
                // ['href' => 'ajout_categorie', 'lib' => 'Ajout Categorie',   'icon' => 'fas fa-plus-circle'],
                ['href' => 'app_logout',    'lib' => 'Logout',          'icon' => 'fas fa-power-off'],


            ];
        }
        else if ($auth->isGranted("ROLE_USER"))
        {
            $liens = [
                ['href' => 'about',         'lib' => 'About',           'icon' => 'fab fa-product-hunt'],
                ['href' => 'contact',       'lib' => 'Contact',         'icon' => 'fas fa-plus-circle'],
                ['href' => 'panier',        'lib' => 'Mon panier',      'icon' => 'fas fa-shopping-basket'],
                ['href' => 'app_logout',    'lib' => 'Logout',          'icon' => 'fas fa-power-off']
            ];
        }
        else
        {
            $liens = [
                ['href' => 'about',          'lib' => 'About',            'icon' => 'fab fa-product-hunt'],
                ['href' => 'contact',       'lib' => 'Contact',         'icon' => 'fas fa-plus-circle'],
                ['href' => 'app_login',     'lib' => 'Login',           'icon' => 'fas fa-sign-in-alt'],
                ['href' => 'app_register',  'lib' => 'Sign Up',         'icon' => 'fas fa-user-plus'],
                // ['href' => 'produits',      'lib' => 'Produits',        'icon' => 'fab fa-product-hunt'],
                // ['href' => 'app_logout',    'lib' => 'Logout',          'icon' => 'fas fa-power-off'],

            ];
        }

        return $this->render('navbar/navbar.html.twig', [
            'liens'     => $liens
        ]);
    }
}
