<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubcatRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProdlistController extends AbstractController
{
    /**
     * @Route("/prodlist", name="prodlist")
     */
    public function index(CategoryRepository $repocat, ProductRepository $repoprod, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $repocat->findAll();
//        $list = $repoprod->findAll();

        $list = $paginator->paginate(
            $repoprod->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('prodlist/index.html.twig', [
            'categories' => $categories,
            'list' => $list
        ]);
    }

    /**
     * @Route("/prodlist2/{id}", name="prodlist2")
     */
    public function index2(CategoryRepository $repocat, SubcatRepository $repoprod, PaginatorInterface $paginator, Request $request, $id): Response
    {
        $categories = $repocat->findAll();
        $subcat = $repoprod->find($id);
//        $list = $subcat->getProducts();

        $list = $paginator->paginate(
            $subcat->getProducts(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('prodlist/index.html.twig', [
            'categories' => $categories,
            'list' => $list,
        ]);
    }

    /**
     * @Route("/prodlist3/{id}", name="prodlist3")
     */
    public function index3(CategoryRepository $repocat, ProductRepository $repoprod, $id): Response
    {
        $categories = $repocat->findAll();
        $list = $repoprod->findByCategory($id);

        return $this->render('prodlist/index.html.twig', [
            'categories' => $categories,
            'list' => $list,
        ]);
    }
}
