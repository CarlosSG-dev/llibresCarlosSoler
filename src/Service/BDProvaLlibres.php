<?php
namespace App\Service;
class BDProvaLlibres{
    private $llibres = array(
        array("isbn"  =>  "A111B3",  "titol"  =>  "El   joc   d'Ender",  "autor"=>"Orson Scott Card", "pagines" => 350),
        array("isbn"  =>  "A123B1",  "titol"  =>  "Don Quixot",  "autor"=>"Miguel de Cervantes", "pagines" => 350),
        array("isbn"  =>  "A123B2",  "titol"  =>  "El senyor dels anells",  "autor"=>"J. R. R. Tolkien", "pagines" => 250),
        array("isbn"  =>  "A123B3",  "titol"  =>  "Harry Potter",  "autor"=>"J.K Rowling", "pagines" => 550), 
        );

        public function get(){return $this->llibres;}

}
?>