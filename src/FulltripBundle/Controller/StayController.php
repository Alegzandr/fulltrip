<?php

namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntityBundle\Entity\Place;
use EntityBundle\Entity\Stay;
use Symfony\Component\HttpFoundation\Response;

class StayController extends Controller
{
    public function addAction($id)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $place = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findOneById($id);

            if (!empty($place)) {
                $stay = $this->getDoctrine()
                    ->getRepository('EntityBundle:Stay')
                    ->findOneByUser($this->get('security.context')->getToken()->getUser());

                if (!empty($stay)) {
                    $stay->setUpdateDate(new \DateTime(date('Y-m-d H:i:s')));
                    $stay->addPlace($place);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($stay);
                    $em->flush();

                    $userPlaces = $stay->getPlaces();
                    $response = new Response();
                    $response->setContent(json_encode(array(
                        'valid' => true,
                        'user_places' => $userPlaces
                    )));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                } else {
                    $stay = new Stay();
                    $stay->setUser($this->get('security.context')->getToken()->getUser());
                    $stay->setAddDate(new \DateTime(date('Y-m-d H:i:s')));
                    $stay->addPlace($place);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($stay);
                    $em->flush();

                    $userPlaces = $stay->getPlaces();
                    $response = new Response();
                    $response->setContent(json_encode(array(
                        'valid' => true,
                        'user_places' => $userPlaces
                    )));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                }
            } else {
                $response = new Response();
                $response->setContent(json_encode(array(
                    'error' => 'Invalid ID'
                )));
                $response->headers->set('Content-Type', 'application/json');
                $response->setStatusCode(400);
                return $response;
            }
        } else {
            $response = new Response();
            $response->setContent(json_encode(array(
                'error' => 'Not logged in'
            )));
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(403);
            return $response;
        }
    }

    public function deleteAction($id)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $place = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findOneById($id);

            if (!empty($place)) {
                $stay = $this->getDoctrine()
                    ->getRepository('EntityBundle:Stay')
                    ->findOneByUser($this->get('security.context')->getToken()->getUser());
                $userPlaces = $stay->getPlaces();

                $stay->removePlace($place);
                $em = $this->getDoctrine()->getManager();
                $em->persist($stay);
                $em->flush();

                $response = new Response();
                $response->setContent(json_encode(array(
                    'valid' => true,
                    'user_places' => $userPlaces
                )));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            } else {
                $response = new Response();
                $response->setContent(json_encode(array(
                    'error' => 'Invalid ID'
                )));
                $response->headers->set('Content-Type', 'application/json');
                $response->setStatusCode(400);
                return $response;
            }
        } else {
            $response = new Response();
            $response->setContent(json_encode(array(
                'error' => 'Not logged in'
            )));
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(403);
            return $response;
        }
    }
}