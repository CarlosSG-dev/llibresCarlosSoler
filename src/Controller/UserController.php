<?php
namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Usuari;
use App\Form\UsuariType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class UserController extends AbstractController {


    /**
     *  @Route("/usuaris", name="usuaris")
     */

     public function mostrar(): Response
     {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accés restringit a administradors');
        $repositori = $this->getDoctrine()->getRepository(Usuari::class);
        $usuaris = $repositori->findAll();
        return $this->render('gestio_usuaris.html.twig', array('usuaris' => $usuaris));

     }

   /**
    *  @Route("/usuari/editar/{id}", name="editar_usuari")
    */
    
    public function editar(UserPasswordEncoderInterface $encoder, Request $request, $id): Response{
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accés restringit a administradors');
        $repositori = $this->getDoctrine()->getRepository(Usuari::class);
        $usu = $repositori->find($id);
        $passAnterior = $usu->getPassword();
        $usu->setPassword("");
        $formulari = $this->createForm(UsuariType::class, $usu);
        $formulari->handleRequest($request);
        if ($formulari->isSubmitted() && $formulari->isValid()) {
            $usu = $formulari->getData();
            $entityManager = $this->getDoctrine()->getManager();
            if ($usu->getPassword() == "") {
                $usu->SetPassword($passAnterior);
            } else {
                $encoded = $encoder->encodePassword($usu, $usu->getPassword());
                $usu->setPassword($encoded);
            }
            $entityManager->persist($usu);
            try {
                $entityManager->flush();
                return $this->redirectToRoute('usuaris');
            } catch (\Exception $e){
                return $this->render('usuari.html.twig', array('formulari' => $formulari->createView()));
            }
        }
        return $this->render('usuari.html.twig', array('formulari' => $formulari->createView()));
    }

    /**
     *  @Route("/usuari/nou", name="nou_usuari")
     */
    public function nou(Request $request, UserPasswordEncoderInterface $encoder): Response {

    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accés restringit a administradors');
    $usu = new Usuari();
    $usu->setRol("ROLE_USER");
    $formulari = $this->createFormBuilder($usu)
    ->add('login', TextType::class, array('label' => 'Login'))
    ->add('password', TextType::class, array('label' => 'Contrasenya'))
    ->add('email', EmailType::class, array('label' => 'Email'))
    ->add('save', SubmitType::class, array('label' => 'Enviar'))
    ->getForm();
    $formulari->handleRequest($request);
    if ($formulari->isSubmitted() && $formulari->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $encoded = $encoder->encodePassword($usu, $usu->getPassword());
        $usu->setPassword($encoded);
        $entityManager->persist($usu);
        try {
            $entityManager->flush();
            return $this->redirectToRoute('usuaris');
        } catch (\Exception $e) {
            return $this->render('usuari.html.twig', array('formulari' => $formulari->createView()));
        }
    }
    return $this->render('usuari.html.twig', array('formulari' => $formulari->createView()));
    }

    /**
     *  @Route("/usuari/eliminar/{id}", name="eliminar_usuari")
     */
    public function eliminar($id): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accés restringit a administradors');
        $repositori = $this->getDoctrine()->getRepository(Usuari::class);
        $usu = $repositori->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($usu);
        $entityManager->flush();
        return $this->redirectToRoute('usuaris');
    }
}

?>