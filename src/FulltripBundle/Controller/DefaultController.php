<?php

namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FulltripBundle\Form\SearchFormType;
use EntityBundle\Entity\Place;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(SearchFormType::class);
        return $this->render('FulltripBundle:Default:index.html.twig', array('form' => $form->createView()));
    }
}
