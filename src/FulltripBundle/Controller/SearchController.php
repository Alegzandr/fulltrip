<?php
namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntityBundle\Entity\Place;
use EntityBundle\Entity\Stay;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FulltripBundle\Form\SearchFormType;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
        $places = new Place();
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $places = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findByCity((array)$form->getData(), array('id' => 'desc'));
        }

        return $this->render(
            'FulltripBundle:Search:index.html.twig',
            array('form' => $form->createView(), 'places' => $places)
        );
    }
}