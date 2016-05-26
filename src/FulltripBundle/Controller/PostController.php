<?php

namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntityBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FulltripBundle\Form\PostFormType;
use FulltripBundle\Form\PostEditFormType;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function showAction($id)
    {
        $place = $this->getDoctrine()
            ->getRepository('EntityBundle:Place')
            ->findOneById($id);
        return $this->render('FulltripBundle:Post:index.html.twig', array('place' => $place));
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