<?php

namespace FulltripBundle\Controller;

use FulltripBundle\Form\PostEditFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntityBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DashboardController extends Controller
{
    public function indexAction()
    {
        if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            $place = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findBy(array(), array('id' => 'desc'));

            return $this->render('FulltripBundle:Dashboard:index.html.twig', array('place' => $place));
        }
        else if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->get('security.context')->getToken()->getUser();
            $place = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findBy(array('user' => $user->getId()), array('id' => 'desc'));
            return $this->render('FulltripBundle:Dashboard:index.html.twig', array('user' => $user, 'place' => $place));
        } else {
            header('Location: /');
            exit;
        }
    }
}
