<?php
//
//namespace App\Controller;
//
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//
//class BillController extends AbstractController
//{
//    /**
//     * @Route("/bill", name="app_bill")
//     */
//    public function index(): Response
//    {
//        return $this->render('bill/index.html.twig', [
//            'controller_name' => 'BillController',
//        ]);
//    }
//}


namespace App\Controller;

use App\Entity\Order;
use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BillController extends AbstractController
{
    /**
     * @Route("/bill/{order}", name="bill")
     */
    public function index(Order $order)
    {
        $pdfOptions = new Options();
//        $pdfOptions->set(array('defaultFont'=> 'Arial', 'isRemoteEnabled'=>true));
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('bill/index.html.twig', [
            'order' => $order,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setCss(new Stylesheet($dompdf));
        $dompdf->setPaper('A4', 'portrait');
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE
            ]
        ]);
        $dompdf->setHttpContext($context);
        $dompdf->render();
        return $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
}

