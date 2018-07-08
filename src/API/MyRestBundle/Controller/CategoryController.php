<?php

namespace API\MyRestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use API\MyRestBundle\Entity\Category;
use API\MyRestBundle\Entity\Product;

class CategoryController extends Controller
{   
    /**
    * 
    * @param Request $request
    * @return Response
    */
    public function newAction(Request $request)
    {
        //recupere les données POSTé par l'utilisateur dans la requete
        $data = $request->getContent();

        //on fait appel au service serializer
        //recupere l'objet category (on ne fait pas new category et setname())
        $category = $this->get('jms_serializer')
                ->deserialize($data, 'API\MyRestBundle\Entity\Category', 'json');
        
        // Get the Doctrine service and manager
        $em = $this->getDoctrine()->getManager();

        // Add our category to Doctrine so that it can be saved
        $em->persist($category);

        // Save our category
        $em->flush();
        
        
        //Response::HTTP_CREATED relatif à statut 201
        return new Response('', Response::HTTP_CREATED);
    }
    
    /**
     * 
     * @return Response en format Json
     */
    public function listAction ()
    {
        $em = $this->getDoctrine()->getManager();
       
        //affiche toutes les categories
        $category = $em->getRepository('APIMyRestBundle:Category')->findAll();
        
        
        $data = $this->get('jms_serializer')->serialize($category, 'json');
       
        
        return new Response ($data, 201, ['Content-Type' => 'application/json']);
    }
    
    /**
     * 
     * @param Category $category
     * @return Response JSON
     */
    public function showAction (Category $category)
    {
        // Faire appel au servise serializer avec la methode serialize()
        // Avec le contenu l'object et dans quel format (JSON) l'objet soit serializer
        $data = $this->get('jms_serializer')->serialize($category, 'json');
    
        // Instancier une reponse avec le JSON bien formaté
        $response = new Response($data);
      
        //ajouter un content type json afin que le client HTTP comprenne qu'il s'agit du json
        $response->headers->set('Content-Type','application/json');
        
        return $response;
    }
    
    //add product
    
    public function addAction(Request $request)
    {
        //recupere les données POSTé par l'utilisateur dans la requete
        $data = $request->getContent();

        //on fait appel au service serializer
        //recupere l'objet category (on ne fait pas new category et setname())
        $category = $this->get('jms_serializer')
                ->deserialize($data, 'API\MyRestBundle\Entity\Category', 'json');
        
        // Get the Doctrine service and manager
        $em = $this->getDoctrine()->getManager();

        // Add our category to Doctrine so that it can be saved
        $em->persist($category);

        // Save our category
        $em->flush();
        
        
        //Response::HTTP_CREATED relatif à statut 201
        return new Response('', Response::HTTP_CREATED);
    }
}
