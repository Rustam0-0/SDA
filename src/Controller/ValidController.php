<?php
//
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//
//class ValidController extends AbstractController
//{
//    /**
//     * @Route("/valid", name="app_valid")
//     */
//    public function index(): Response
//    {
//        return $this->render('valid/index.html.twig', [
//            'controller_name' => 'ValidController',
//        ]);
//    }
//}


namespace App\Controller;

use App\Entity\Client;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ValidController extends AbstractController
{
    /**
     * @Route("/valid", name="valid")
     */
    public function index(ClientRepository $cli, SessionInterface $session, ProductRepository $prod, CategoryRepository $repocat, Request $request, EntityManagerInterface $em): Response
    {
        dump($this->getUser());

        $categories = $repocat->findAll();

        $cart = $session->get("cart", []);
        foreach ($cart as $key => $value) {
            $product = $prod->find($key);
            $cart[$key]['price'] = $product->getPrice();
        }

        if (empty($cart)) {
            return $this->redirectToRoute('prodlist');
        }

//        dump($cart);

        if ($request->isMethod("post")) {

            $id = $cli->find($request->get("id"));
            $name = $request->get("name");
            $surname = $request->get("surname");
            $address = $request->get("address");
            $zipcode = $request->get("zipcode");
            $city = $request->get("city");
            $tel = $request->get("tel");
            $payer = $request->get("payer");

            $ord = new Order();
            $ord->setClient($id);
            $ord->setShipName($name);
            $ord->setShipSurname($surname);
            $ord->setShipAddress($address);
            $ord->setShipZipcode($zipcode);
            $ord->setShipCity($city);
            $ord->setShipTel($tel);
            $ord->setDate(new \DateTime());
            $ord->setPayer($payer);

            $em->persist($ord);

//            $total =0;
            foreach ($cart as $key => $value) {
                $det = new OrderDetail();
                $product = $prod->find($key);
                $cart[$key]['price'] = $product->getPrice();
//                $total += $cart[$key]['price'] * $cart[$key]['qty'];
                $det->setProduct($product);
                $det->setQuantity($cart[$key]['qty']);
                $det->setPrice($cart[$key]['price']);
                $det->setOrders($ord);
                $em->persist($det);
            }
            $em->flush();
            $session->set('cart', []);
            return $this->redirectToRoute('my_orders');
        }
        return $this->render('valid/index.html.twig', [
            'categories' => $categories,
            'controller_name' => 'ValidController',
            'cart' => $cart,
            'user' => $this->getUser()
        ]);
    }
}

