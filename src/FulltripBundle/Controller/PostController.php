<?php

namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntityBundle\Entity\Place;
use EntityBundle\Entity\Review;
use Symfony\Component\HttpFoundation\Request;
use FulltripBundle\Form\PostFormType;
use FulltripBundle\Form\PostEditFormType;
use Symfony\Component\HttpFoundation\Response;
use FulltripBundle\Form\ReviewFormType;

class PostController extends Controller
{
    public function showAction($id)
    {
        $place = $this->getDoctrine()
            ->getRepository('EntityBundle:Place')
            ->findOneById($id);
        $reviews = $this->getDoctrine()
            ->getRepository('EntityBundle:Review')
            ->findByPlace($place);

        $form = $this->createForm(ReviewFormType::class);

        return $this->render('FulltripBundle:Post:index.html.twig', array(
            'place' => $place,
            'form' => $form->createView(),
            'reviews' => $reviews
        ));
    }

    public function createAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $place = new Place();
            $form = $this->createForm(PostFormType::class, $place);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $place->setUser($this->getUser());
                $place->setAddDate(new \DateTime(date('Y-m-d H:i:s')));

                $from = $form['address']->getData() . ', ' . $form['zipCode']->getData() . ' ' . $form['city']->getData();
                $to = $form['city']->getData();
                $from = urlencode($from);
                $to = urlencode($to);
                $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
                $data = json_decode($data);
                $distance = 0;
                foreach($data->rows[0]->elements as $road) {
                    $distance += $road->distance->value;
                }
                $place->setDistance($distance);

                $em = $this->getDoctrine()->getManager();
                $em->persist($place);
                $em->flush();

                $response = new Response();
                $response->setContent(json_encode(array(
                    'success' => true
                )));
                $response->headers->set('Content-Type', 'application/json');
                return $this->redirectToRoute('fulltrip_dashboard');
            } elseif ($form->isSubmitted()) {
                $errors = array();

                foreach ($form->getErrors() as $error) {
                    $errors[$form->getName()][] = $error->getMessage();
                }

                foreach ($form as $child/** @var Form $child */) {
                    if (!$child->isValid()) {
                        foreach ($child->getErrors() as $error) {
                            $errors[$child->getName()][] = $error->getMessage();
                        }
                    }
                }

                $response = new Response();
                $response->setContent(json_encode($errors));
                $response->headers->set('Content-Type', 'application/json');
                $response->setStatusCode(400);
                return $response;
            }

            return $this->render(
                'FulltripBundle:Post:create.html.twig',
                array('form' => $form->createView())
            );
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    public function editAction(Request $request, $id)
    {

        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $place = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findOneById(array($id));

            if ($place->getUser() === $this->get('security.context')->getToken()->getUser() || $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
                $form = $this->createForm(PostEditFormType::class, $place);

                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $place->setUpdateDate(new \DateTime(date('Y-m-d H:i:s')));

                    $from = $form['address']->getData() . ', ' . $form['zipCode']->getData() . ' ' . $form['city']->getData();
                    $to = $form['city']->getData();
                    $from = urlencode($from);
                    $to = urlencode($to);
                    $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
                    $data = json_decode($data);
                    $distance = 0;
                    foreach($data->rows[0]->elements as $road) {
                        $distance += $road->distance->value;
                    }
                    $place->setDistance($distance);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($place);
                    $em->flush();

                    $response = new Response();
                    $response->setContent(json_encode(array(
                        'success' => true
                    )));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                } elseif ($form->isSubmitted()) {
                    $errors = array();

                    foreach ($form->getErrors() as $error) {
                        $errors[$form->getName()][] = $error->getMessage();
                    }

                    foreach ($form as $child/** @var Form $child */) {
                        if (!$child->isValid()) {
                            foreach ($child->getErrors() as $error) {
                                $errors[$child->getName()][] = $error->getMessage();
                            }
                        }
                    }

                    $response = new Response();
                    $response->setContent(json_encode($errors));
                    $response->headers->set('Content-Type', 'application/json');
                    $response->setStatusCode(400);
                    return $response;
                }

                return $this->render(
                    'FulltripBundle:Post:edit.html.twig',
                    array('form' => $form->createView(), 'place' => $place)
                );
            }
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    public function deleteAction($id)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $place = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findOneById(array($id));
            if ($place->getUser() === $this->container->get('security.context')->getToken()->getUser() || $this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($place);
                $em->flush();
            }
            return $this->redirectToRoute('fulltrip_dashboard');
        }
        return $this->redirectToRoute('fulltrip_homepage');
    }
}