<?php

namespace FulltripBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FulltripBundle:Default:index.html.twig');
    }
}
