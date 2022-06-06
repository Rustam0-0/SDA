<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(CategoryRepository $repocat, OrderRepository $order): Response
    {
        $categories = $repocat->findAll();
        $orders = $order->findAll();
        $clients = $order->findBy(['client' => $this->getUser()->getClient()]);
//        dump($orders);
        return $this->render('admin/index.html.twig', [
            'categories' => $categories,
            'orders' => $orders,
//            'clients' => $clients
        ]);
    }
}
