<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="app_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository, CategoryRepository $repocat): Response
    {
        $categories = $repocat->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository, CategoryRepository $repocat): Response
    {
        $categories = $repocat->findAll();
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setDateAdd(new \DateTime());
            //   dd($request);
            $aMimeTypes = array("image/gif", "image/jpeg", "image/jpg", "image/png", "image/x-png", "image/tiff");
            //   $img = ['product']['photo'];
            $objfichier = $request->files->get('product');
            $fichier = $objfichier['picture'];
            if (!empty($fichier)) {
                if (in_array($fichier->getClientmimeType(), $aMimeTypes)) {
                    if ($fichier->move('assets/images/PRODUCTS/', $fichier->getClientOriginalName())) {
                        $product->setPicture($fichier->getClientOriginalName());
                    }
                }
            }
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash('success', 'Produit est ajouté');
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_show", methods={"GET"})
     */
    public function show(Product $product, CategoryRepository $repocat): Response
    {
        $categories = $repocat->findAll();
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager, ProductRepository $productRepository, CategoryRepository $repocat): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $product->setPicture($product->getPicture());

        if ($form->isSubmitted() && $form->isValid()) {
            $aMimeTypes = array("image/gif", "image/jpeg", "image/jpg", "image/png", "image/x-png", "image/tiff");
            //   $img = ['products']['photo'];
            $objfichier = $request->files->get('product');

            $fichier = $objfichier['picture'];
            if (!empty($fichier)&& in_array($fichier->getClientmimeType(), $aMimeTypes)) {
                if ($fichier->move('assets/images/PRODUCTS/', $fichier->getClientOriginalName())) {
                    $product->setPicture($fichier->getClientOriginalName());
                }
            }
            $product->setDateUpdate(new \DateTime());
            $entityManager->flush();
            $this->addFlash('success', 'Produit est edité');
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }
        $categories = $repocat->findAll();
        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository, CategoryRepository  $repocat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product);
        }

        $categories = $repocat->findAll();
        return $this->redirectToRoute('app_product_index', [
            'categories' => $categories
        ], Response::HTTP_SEE_OTHER);
    }
}
