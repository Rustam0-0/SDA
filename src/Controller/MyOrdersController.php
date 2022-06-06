<?php
//
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//
//class MyOrdersController extends AbstractController
//{
//    /**
//     * @Route("/my/orders", name="app_my_orders")
//     */
//    public function index(): Response
//    {
//        return $this->render('my_orders/index.html.twig', [
//            'controller_name' => 'MyOrdersController',
//        ]);
//    }
//}


namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MyOrdersController extends AbstractController
{
    /**
     * @Route("/my_orders", name="my_orders")
     */
    public function index(CategoryRepository $repocat, OrderRepository $ord): Response
    {
        // one way
//        $idclient = $user->find($this->getUser())->getClient();
//        dd($this->getUser());
//        $orderClient = $ord->findBy(['client'=>$idclient]);
        //dd($orderClient);

        // another way
        $orderClient = $ord->findBy(['client' => $this->getUser()->getClient()]);
        $categories = $repocat->findAll();
//        dump($orderClient);
        return $this->render('my_orders/index.html.twig', [
            'categories' => $categories,
            'orders' => $orderClient,
            'controller_name' => 'MyOrdersController'
        ]);
    }

//    /**
//     * @Route("/admin/orders", name="admin_orders")
//     */
//    public function index2(CategoryRepository $repocat, OrderRepository $ord): Response
//    {
//        $orders = $ord->findAll();
//        $categories = $repocat->findAll();
////        dump($orders);
//        return $this->render('my_orders/index.html.twig', [
//            'categories' => $categories,
//            'orders' => $orders,
//            'controller_name' => 'MyOrdersController'
//        ]);
//    }
}

