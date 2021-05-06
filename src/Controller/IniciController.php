<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use App\Service\BDProvaLlibres;
use App\Entity\Llibre;




class IniciController extends AbstractController{

    // private $logger;
    // private $llibres;
    
    
    
    // public function __construct(LoggerInterface $logger,$bdProva)
    // {
    //     $this->logger = $logger;
    //     $this->llibres = $bdProva->get();
    
        
    // }

    
   
   

    /*** @Route("/", name="inici")*/
    
    public function inici(){
        $repositori = $this->getDoctrine()->getRepository(Llibre::class);
        $llibre = $repositori->findAll();
        // $data_hora = new \DateTime();
        // $this->logger->info("Accés el " 
        // .$data_hora->format("d/m/y H:i:s"));
        return $this->render('inici.html.twig',
        array('llibres' => $llibre));
    }

 


   
}
?>