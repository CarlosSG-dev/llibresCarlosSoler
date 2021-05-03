<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class llibreController extends AbstractController
{
    
    private $llibres = array(
        array("isbn"  =>  "A111B3",  "titol"  =>  "El   joc   d'Ender",  "autor"=>"Orson Scott Card", "pagines" => 350),
        array("isbn"  =>  "A123B1",  "titol"  =>  "Don Quixot",  "autor"=>"Miguel de Cervantes", "pagines" => 350),
        array("isbn"  =>  "A123B2",  "titol"  =>  "El senyor dels anells",  "autor"=>"J. R. R. Tolkien", "pagines" => 250),
        array("isbn"  =>  "A123B3",  "titol"  =>  "Harry Potter",  "autor"=>"J.K Rowling", "pagines" => 550), 
        );
    /**
     * @Route("/llibre/{isbn}", name="fitxa_llibre")
     */
    public function fitxa($isbn = "A111B3")
    {
        $resultat = array_filter($this->llibres,
        function($llibre) use ($isbn)
        {return $llibre["isbn"] == $isbn;
        });
        if (count($resultat) > 0)
        {
            return $this->render('fitxa_llibre.html.twig',
                        array('llibre' => array_shift($resultat)));
            }
            else 
            return $this->render('fitxa_llibre.html.twig', 
                        array('llibre' => NULL));
            }
            }
        /**
         * @Route("/llibre/{isbn}", name="buscar_llibre")
         * */

     function buscar($isbn)
            {
                $resultat = array_filter($this->llibres,
                function($llibre) use ($isbn)
                {
                    return strpos($llibre["titol"], $isbn) !== FALSE;
                });
                return $this->render('llista_llibres.html.twig',
                array('llibres' => $resultat));
                
            }
?>