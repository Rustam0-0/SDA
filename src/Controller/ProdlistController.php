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
        $list_promos = $repoprod->findByPromo();
//        $list = $repoprod->findAll();

        $list = $paginator->paginate(
            $repoprod->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('prodlist/index.html.twig', [
            'categories' => $categories,
            'list' => $list,
            'list_promos' => $list_promos
        ]);
    }

    /**
     * @Route("/prodlist2/{id}", name="prodlist2")
     */
    public function index2(CategoryRepository $repocat, SubcatRepository $repoprod, ProductRepository $repopromo, PaginatorInterface $paginator, Request $request, $id): Response
    {
        $categories = $repocat->findAll();
        $subcat = $repoprod->find($id);
        $list_promos = $repopromo->findByPromo();
//        $list = $subcat->getProducts();

        $list = $paginator->paginate(
            $subcat->getProducts(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('prodlist/index.html.twig', [
            'categories' => $categories,
            'list' => $list,
            'list_promos' => $list_promos
        ]);
    }

    /**
     * @Route("/prodlist3/{id}", name="prodlist3")
     */
    public function index3(CategoryRepository $repocat, ProductRepository $repoprod, $id): Response
    {
        $list_promos = $repoprod->findByPromo();
        $categories = $repocat->findAll();
        $list = $repoprod->findByCategory($id);

        return $this->render('prodlist/index.html.twig', [
            'categories' => $categories,
            'list' => $list,
            'list_promos' => $list_promos
        ]);
    }

    /**
     * @Route("/search", name="prodlist_search")
     */
    public function index4(ProductRepository $repo, CategoryRepository $cat, Request $request): Response
    {
        $name = $request->get('q');
        $list_promos = $repo->findByPromo();
        //   dump($name);
        //   dump($repo->findBySearch($name));

        if ($repo->findBySearch($name)) {
            $this->addFlash('success', 'Resultat de votre recherche pour: ');
        }
        else {
            $this->addFlash('warning', "Oups, on n'a rien trouvé pour: ");
        }
        return $this->render('prodlist/index.html.twig', [
            'categories'=> $cat->findAll(),
            'list' => $repo->findBySearch($name),
            'list_promos' => $list_promos
        ]);
    }

    /**
     * @Route("/promo_list", name="promo_list")
     */
    public function index5(CategoryRepository $repocat, ProductRepository $repoprod, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $repocat->findAll();
//        $list = $repoprod->findBy(array('promo' => Null));
        $list_promos = $repoprod->findByPromo();

//        $list = $paginator->paginate(
//            $repoprod->findAll(),
//            $request->query->getInt('page', 1),
//            10
//        );

        return $this->render('promo_list/index.html.twig', [
            'categories' => $categories,
//            'list' => $list,
            'list_promos' => $list_promos
        ]);
    }
}
