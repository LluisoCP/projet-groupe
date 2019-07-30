<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\TagRepository;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ProduitType;

/**
 * @Route("/produits")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produits", methods={"GET", "POST"})
     */
    public function index(ProduitRepository $produit_repository)
    {
        $produits = $produit_repository->findAll();
        return $this->render('produit/tous.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/results", name="results")
     */
    public function results(Request $request, ProduitRepository $produit_repository, SerializerInterface $serializer)
    {
        $price = $request->query->get('price');
        $order = $request->query->get('order');
        $produits = $produit_repository->findByPrice($price, $order);

        $jsonProduits = $serializer->serialize($produits, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($jsonProduits, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/create", name="createProduit", methods={"GET", "POST"})
     */
    public function createProduit(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            // 1. Rediect:
            return $this->redirectToRoute('home');
            /**
             * 2. Display same page: (sans handleRequest())
             * unset($form);
             * unset($deet);
             * $deet = new Deet();
             * $form = $this->createForm(DeetType::class, $deet);
             */
        }


        return $this->render('produit/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit", methods={"GET", "POST"})
     */
    public function show($id, ProduitRepository $produit)
    {
        $liste = $produit->findBy(['id' => $id]);
        return $this->render('produit/show.html.twig', [
            'title' => "Nos produits",
            'liste' => $liste
        ]);
    }


    /**
     * @Route("/categorie/{nom}", name="cat_produits", methods={"GET"})
     */
    public function cat_produit(CategorieRepository $categorie_repository, $nom): Response
    {
        $categorie = $categorie_repository->findOneBy(['nom' => $nom]);
        $produits = $categorie->getProduits();

        return $this->render('categorie/produits.html.twig', [
            'produits'   => $produits,
            'categorie'  => $categorie->getNom()
        ]);
    }

    /**
     * @Route("/tag/{nom}", name="tag_produits", methods={"GET"})
     */
    public function tag_produit(TagRepository $tag_repository, $nom): Response
    {
        $tag = $tag_repository->findOneBy(['nom' => $nom]);
        $produits = $tag->getProduits();

        // foreach($produits as $p) {
        //     dump($p);
        // }

        // die;

        return $this->render('tag/produits.html.twig', [
            'produits'  => $produits,
            'tag'       => $tag->getNom()
        ]);
    }
}
