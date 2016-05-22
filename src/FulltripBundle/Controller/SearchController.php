<?php
namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EntityBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FulltripBundle\Form\SearchType;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
        $places = new Place();
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $places = $this->getDoctrine()
                ->getRepository('EntityBundle:Place')
                ->findByCity((array) $form->getData(), array('id' => 'desc'));
        }

        return $this->render(
            'FulltripBundle:Search:index.html.twig',
            array('form' => $form->createView(), 'places' => $places)
        );
    }
}