<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{slug}", name="product_show")
     */
    public function show($slug)
    {
        // On récupère le dépôt qui contient nos produits
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        // SELECT * FROM product WHERE slug = $slug
        // $productRepository->findOneBy(['slug' => $slug]);
        /** @var Product $product */
        $product = $productRepository->findOneBySlug($slug);

        // User
        // dump($product->getUser()->getUsername());

        // Si le produit n'existe pas en BDD
        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product", name="product_list")
     * @param ProductRepository $productRepository
     * @return Response
    */
    public function list(ProductRepository $productRepository)
    {

        $products = $productRepository->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }
}
