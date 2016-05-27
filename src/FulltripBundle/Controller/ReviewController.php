<?php

namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntityBundle\Entity\Review;
use EntityBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FulltripBundle\Form\ReviewFormType;

class ReviewController extends Controller
{
    public function postAction(Request $request, $id)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $review = new Review();
            $place = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findOneById(array($id));

            $form = $this->createForm(ReviewFormType::class, $review);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $review->setUser($this->getUser());
                $review->setPlace($place);
                $review->setAddDate(new \DateTime(date('Y-m-d H:i:s')));

                $em = $this->getDoctrine()->getManager();
                $em->persist($review);
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
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }
}