<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Llibre;
use App\Entity\Editorial;
use App\Form\LlibreType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;




class llibreController extends AbstractController
{


/**
* @Route("/llibre/inserir", name="inserir_llibre")
*/

public function inserir()
{


$entityManager = $this->getDoctrine()->getManager();
$llibre = new Llibre();
$llibre->setIsbn("7777SSSS");
$llibre->setTitol("Noruega");
$llibre->setAutor("Rafa Lahuerta");
$llibre->setPagines("387");
$entityManager->persist($llibre);


$llibre2 = new Llibre();
$llibre2->setIsbn("A111B3");
$llibre2->setTitol("Don Quixot");
$llibre2->setAutor("Miguel de Cervantes");
$llibre2->setPagines("350");
$entityManager->persist($llibre2);


$llibre3 = new Llibre();
$llibre3->setIsbn("A123B1");
$llibre3->setTitol("El señor dels anells");
$llibre3->setAutor("J. R. R. Tolkien");
$llibre3->setPagines("250");
$entityManager->persist($llibre3);



$llibre4 = new Llibre();
$llibre4->setIsbn("A123B3");
$llibre4->setTitol("Harry Potter");
$llibre4->setAutor("J.K. Rowling");
$llibre4->setPagines("550");
$entityManager->persist($llibre4);
try
{
$entityManager->flush();
return new Response("Llibres inserits amb isbn: " . $llibre->getIsbn() ." ". $llibre2->getIsbn()
." ". $llibre3->getIsbn() ." ". $llibre4->getIsbn());
} catch (\Exception $e) {
    return new Response("Error inserint els llibres  amb isbn: " . $llibre->getIsbn() ." ". $llibre2->getIsbn()
    ." ". $llibre3->getIsbn() ." ". $llibre4->getIsbn());
}

}


/**
* @Route("/llibre/inserirAmbEditorial", name="inserir_editorial_llibre")
*/

public function inserirAmbEditorial() {

    $entityManager = $this->getDoctrine()->getManager();

    $editorial = new Editorial();
    $editorial->setNom("Bromera");
    $llibre5 = new Llibre();
    $llibre5->setIsbn("8888TTTT");
    $llibre5->setTitol("El teu gust");
    $llibre5->setAutor("Isabel Clara Simó");
    $llibre5->setPagines("208");
    $llibre5->setEditorial($editorial);
    $entityManager->persist($editorial);
    $entityManager->persist($llibre5);
    try
    {
    $entityManager->flush();
    return new Response("Llibre amb Editorial inserit amb isbn: " . $llibre5->getIsbn());
    } catch (\Exception $e) {
        return new Response("Error inserint el llibre amb Editorial amb isbn: " . $llibre5->getIsbn());
    }
}

/**
* @Route("/llibre/nou", name="nou_llibre")
*/

public function nou(Request $request) {
    $llibre = new Llibre();
    $formulari = $this->createForm(LlibreType::class, $llibre);

    $formulari->handleRequest($request);
    if ($formulari->isSubmitted() && $formulari->isValid()) {
        $llibre = $formulari->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($llibre);
    }
    try {
        $entityManager->flush();
        return $this->redirectToRoute('inici');
    } catch (\Exception $e) {
        return $this->render('nou.html.twig', array('formulari' => $formulari->createView()));
    }
}


/**
* @Route("/llibre/editar/{isbn}", name="editar_llibre")
*/

public function editar(Request $request, $isbn) {
    $repositori = $this->getDoctrine()->getRepository(Llibre::class);
    $llibre = $repositori->find($isbn);
    $formulari = $this->createForm(LlibreType::class, $llibre);

    $formulari->handleRequest($request);
    if ($formulari->isSubmitted() && $formulari->isValid()) {
        $llibre = $formulari->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($llibre);
    }
    try {
        $entityManager->flush();
        return $this->redirectToRoute('inici');
    } catch (\Exception $e) {
        return $this->render('nou.html.twig', array('formulari' => $formulari->createView()));
    }
}

    // private $llibres;

    // public function __construct(BDProvaLlibres $dades){
    //     $this->llibres = $dades->get();
    // }
    
    /**
     * @Route("/llibre/{isbn}", name="fitxa_llibre")
     */
    
    public function fitxa($isbn)
    {
        $repositori = $this->getDoctrine()->getRepository(Llibre::class);
        $llibre = $repositori->find($isbn);
        if ($llibre)
        return $this->render('fitxa_llibre.html.twig',
        array('llibre' => $llibre));
        else
        return $this->render('fitxa_llibre.html.twig',
        array('llibre' => NULL));
        }
    

        
/**
* @Route("/llibre/pagines/{pagines}", name="filtrar_llibre")
*/

 public function filtrarPagines($pagines){

    $repositori = $this->getDoctrine()->getRepository(Llibre::class);
    $resultat = $repositori->findSomeBySomeField($pagines);
    return $this->render('inici.html.twig', array('llibres' => $resultat));
}




    //     
    //     /**
    //      * @Route("/llibre/{isbn}", name="buscar_llibre")
    //      * */

    //  function buscar($isbn)
    //         {
    //             $resultat = array_filter($this->llibres,
    //             function($llibre) use ($isbn)
    //             {
    //                 return strpos($llibre["titol"], $isbn) !== FALSE;
    //             });
    //             return $this->render('llista_llibres.html.twig',
    //             array('llibres' => $resultat));
                
            }
?>