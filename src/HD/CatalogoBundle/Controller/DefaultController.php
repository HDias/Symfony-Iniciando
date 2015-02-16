<?php

namespace HD\CatalogoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CatalogoBundle:Default:index.html.twig', array('name' => $name));
    }
}
