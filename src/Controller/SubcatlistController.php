<?php
//
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//
//class SubcatlistController extends AbstractController
//{
//    /**
//     * @Route("/subcatlist", name="app_subcatlist")
//     */
//    public function index(): Response
//    {
//        return $this->render('subcatlist/index.html.twig', [
//            'controller_name' => 'SubcatlistController',
//        ]);
//    }
//}


namespace App\Controller;

use App\Entity\Product;
use App\Entity\Subcat;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubcatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubcatlistController extends AbstractController
{
    /**
     * @Route("/subcatlist/{id}", name="subcatlist")
     */
    public function index(CategoryRepository $repocat, $id): Response
    {
        $categories = $repocat->findAll();
        $subcat = $repocat->find($id);
        $list = $subcat->getSubcats();

        return $this->render('subcatlist/index.html.twig', [
            'categories' => $categories,
            'list' => $list
        ]);
    }
}

