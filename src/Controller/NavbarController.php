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
                ['href' => 'admin_clients',     'lib' => 'Clients',         'icon' => 'fas fa-users'],
                ['href' => 'admin_produits',    'lib' => 'Produits',        'icon' => 'fab fa-product-hunt'],
                ['href' => 'admin_paniers',     'lib' => 'Paniers',         'icon' => 'fas fa-shopping-basket'],
                // ['href' => 'createProduit',     'lib' => 'Ajout Produit',   'icon' => 'fas fa-plus-circle'],
                ['href' => 'tag_index',         'lib' => 'Etiquettes',      'icon' => 'fas fa-tags'],
                ['href' => 'categorie_index',   'lib' => 'Categories',      'icon' => 'fas fa-layer-group'],
                ['href' => 'app_logout',        'lib' => 'Logout',          'icon' => 'fas fa-power-off'],
            ];

            $bienvenue = 'Bienvenue à votre espace admin';
        }
        else if ($auth->isGranted("ROLE_USER"))
        {
            $liens = [
                ['href' => 'about',         'lib' => 'About',           'icon' => 'fab fa-product-hunt'],
                ['href' => 'contact',       'lib' => 'Contact',         'icon' => 'fas fa-plus-circle'],
                ['href' => 'mon_panier',        'lib' => 'Mon panier',      'icon' => 'fas fa-shopping-basket'],
                ['href' => 'app_logout',    'lib' => 'Logout',          'icon' => 'fas fa-power-off']
            ];
            $bienvenue = 'Bienvenue à votre espace projet.com';
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
            $bienvenue = '';
        }

        return $this->render('navbar/navbar.html.twig', [
            'liens'     => $liens,
            'bienvenue' => $bienvenue
        ]);
    }
}
