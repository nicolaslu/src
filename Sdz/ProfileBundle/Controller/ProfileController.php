<?php

namespace Sdz\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sdz\ProfileBundle\Entity\Publication;

class ProfileController extends Controller
{
    public function indexAction()
    {
        $securityContext = $this->container->get('security.context');
        if( $securityContext->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $userId = $securityContext->getToken()->getUser()->getId();
            if(isset($userId))
            {
                $em = $this->getDoctrine()->getEntityManager();
                $query = $em->createQuery('SELECT p FROM SdzProfileBundle:Publication p WHERE p.idUser = '. $userId .'order by p.date DESC');
                $res = $query->getResult();
            }
            return $this->render('SdzProfileBundle::layout.html.twig', array('publication' => $res));
        }
        else
        {
            return $this->redirect($this->generateUrl('sdz_login'));  
        }
    }

    public function postAction()
    {
        $securityContext = $this->container->get('security.context');
        if( $securityContext->isGranted('IS_AUTHENTICATED_FULLY'))
        {
        	$em = $this->getDoctrine()->getEntityManager();
            $userId =$this->container->get('security.context')->getToken()->getUser()->getId();
        	if(isset($_POST['textaenvoyer']) && $_POST['textaenvoyer']!="Write your message" &&isset($userId))
    		{
    			$msg = new Publication();
    			$msg->setTexte($_POST['textaenvoyer']);
                $msg->setIdUser($this->container->get('security.context')->getToken()->getUser()->getId());

    			// Étape 1 : On « persiste » l'entité
        		$em->persist($msg);

    		    // Étape 2 : On « flush » tout ce qui a été persisté avant
    		    $em->flush();
    		}
        	return $this->redirect($this->generateUrl('sdz_profile'));
            }
        else
        {
            return $this->redirect($this->generateUrl('sdz_login'));  
        }
    }
}

