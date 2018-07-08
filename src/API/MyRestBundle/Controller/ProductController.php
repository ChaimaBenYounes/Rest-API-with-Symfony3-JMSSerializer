<?php

namespace API\MyRestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use API\MyRestBundle\Entity\Category;
use API\MyRestBundle\Entity\Product;

/**
 * 
 * Class ProductController
 * 
 */
class ProductController extends Controller
{   
    
    public function newAction(Request $request)
    {
        //recupere les données POSTé par l'utilisateur dans la requete
        $data = $request->getContent();
        
        
        /*foreach ($product->getCategories() as $categorie )
        {
            $product->addCategory($categorie);
        }*/
        
        //on fait appel au service serializer
        //recupere l'objet category (on ne fait pas new category et setname())
        $product = $this->get('jms_serializer')
                ->deserialize($data, 'API\MyRestBundle\Entity\Product', 'json');
        
        //$this->get('validator')->validate($product);

        
        /*dump($product->getCategories()); die;
        
        foreach ($product->getCategories() as $categorie )
        {
            $product->addCategory($categorie);
        }
        */
         
        // Get the Doctrine service and manager
        $em = $this->getDoctrine()->getManager();

        // Add our category to Doctrine so that it can be saved
        $em->persist($product);

        // Save our category
        $em->flush();
        
        // Refresh the sheld
        
        $em->refresh($product->getCategories());
        
        dump($product);
        
        
        
        //Response::HTTP_CREATED relatif à statut 201
        return new Response('', Response::HTTP_CREATED);
    }
}

