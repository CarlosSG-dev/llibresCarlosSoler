<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use App\Service\BDProvaLlibres;
use App\Entity\Llibre;
use Jenssegers\Date\Date;




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

        Date::setLocale('ca');
        $date = Date::now()->format('l j \de F \d\e\l Y\, \c\a\r\r\e\g\a\t \a \l\e\s h:i:s');
        $date =ucfirst($date);
        return $this->render('inici.html.twig',
        array('llibres' => $llibre, 'date' => $date));
    }

 


   
}
?>