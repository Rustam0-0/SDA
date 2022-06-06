<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\CategoryRepository;
//use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
//use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdDetController extends AbstractController
{
    /**
     * @Route("/ord_det/{order}", name="ord_det")
     */
    public function index(CategoryRepository $repocat, Order $order): Response
    {
        $categories = $repocat->findAll();
        return $this->render('ord_det/index.html.twig', [
            'categories' => $categories,
            'order' => $order,
            'controller_name' => 'OrdDetController',
        ]);
    }
}
