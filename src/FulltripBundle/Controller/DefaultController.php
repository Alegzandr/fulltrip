<?php

namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FulltripBundle\Form\SearchType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(SearchType::class);
        return $this->render('FulltripBundle:Default:index.html.twig', array('form' => $form->createView()));
    }
}
