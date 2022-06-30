<?php
//
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//
//class SingupController extends AbstractController
//{
//    /**
//     * @Route("/singup", name="app_singup")
//     */
//    public function index(): Response
//    {
//        return $this->render('singup/index.html.twig', [
//            'controller_name' => 'SingupController',
//        ]);
//    }
//}


namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SingupController extends AbstractController
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function singup(ClientRepository $client, CategoryRepository $repocat, Request $request, EntityManagerInterface $em): Response
    {
        $categories = $repocat->findAll();
        $form = $this->createForm(ClientType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            //dd($task);

            $cli = new Client();
            $cli->setName($task["name"]);
            $cli->setSurname($task["surname"]);
            $cli->setTel($task["tel"]);
            $cli->setAddress($task["address"]);
                //$cli->setZipcode($task["zipcode"]);
                //$cli->setCity($task["city"]);
            $cli->setZipcode("80000");
            $cli->setCity("Amiens");
            $cli->setDateAdd(new \DateTime());

            $cli->setUser($this->getUser());

            $em->persist($cli);
            $em->flush();


            // ... perform some action, such as saving the task to the database
            // $this->addFlash('success', 'Vous êtes bien inscrit. Veuillez vous êntrer avec vos Email et mot de passe!');
            return $this->redirectToRoute('home');
        }

        return $this->render('singup/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()

        ]);
    }
}

