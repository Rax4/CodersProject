<?php

namespace BandMergerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FileController extends Controller
{
    /**
     * @Route("/create")
     */
    public function createAction()
    {
        return $this->render('BandMergerBundle:File:create.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/edit")
     */
    public function editAction()
    {
        return $this->render('BandMergerBundle:File:edit.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/remove")
     */
    public function removeAction()
    {
        return $this->render('BandMergerBundle:File:remove.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/validate")
     */
    public function validateAction()
    {
        return $this->render('BandMergerBundle:File:validate.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/merge")
     */
    public function mergeAction()
    {
        return $this->render('BandMergerBundle:File:merge.html.twig', array(
            // ...
        ));
    }

}
