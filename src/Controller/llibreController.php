<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class llibreController 
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
            $resposta = "";
            $resultat = array_shift($resultat);
            $resposta .= "<ul><li>" . $resultat["titol"] . "</li>" .
            "<li>" . $resultat["autor"] . "</li>" .
            "<li>" . $resultat["pagines"] . "</li></ul>";
            return new Response("<html><body>$resposta</body></html>");
            }
            else 
            return new Response("llibre no trobat");
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
                $resposta = "";
                if (count($resultat) > 0)
                {
                    foreach ($resultat as $llibre)
                    $resposta .= "<ul><li>" . $llibre["titol"] . "</li>" .
                    "<li>" . $llibre["autor"] . "</li>" .
                    "<li>" . $llibre["pagines"] . "</li></ul>";
                    return new Response("<html><body>" . $resposta . "</body></html>");
                }
                else
                return new Response("No s'han trobat llibres");
            }
?>