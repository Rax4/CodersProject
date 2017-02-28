<?php

namespace BandMergerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BandMergerBundle\Entity\Instrument;
use BandMergerBundle\Entity\Band;
use BandMergerBundle\Entity\Project;
use BandMergerBundle\Entity\File;
use BandMergerBundle\Entity\User;

class ViewController extends Controller
{
    private function checkAcces(Band $band)
    {
        $bool = false;
        $users = $band->getUsers();
        foreach ($users as $user)
        {
            if ($this->getUser() === $user)
            {
                $bool = true;
                continue;
            }
        }
        if ($bool===false)
        {
            throw new \Exception("Acces Denied!");
        }
    }

    /**
     * @Route("/myBands")
     */
    public function viewAllBandsAction()
    {
        $user = new User();
        $user = $this->getUser();
        $bands = $user->getBands();
        return $this->render('BandMergerBundle:View:view_all_bands.html.twig', array(
            'bands'=>$bands,
        ));
    }

    /**
     * @Route("/")
     */
    public function viewPublicBandsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BandMergerBundle:Band');
        $bands = $repo->findByPublic(1);
        return $this->render('BandMergerBundle:View:view_all_public_bands.html.twig', array(
            'bands'=>$bands,
        ));
    }

    /**
     * @Route("/viewBand/{id}")
     */
    public function viewBandAction(Band $band)
    {
        $this->checkAcces($band);
        return $this->render('BandMergerBundle:View:view_band.html.twig', array(
            'band'=>$band,
            'admin'=>  $this->getUser()
        ));
    }

    /**
     * @Route("/viewProject/{id}")
     */
    public function viewProjectAction(Project $project)
    {
        $this->checkAcces($project->getBand());
        return $this->render('BandMergerBundle:View:view_project.html.twig', array(
            'project'=>$project,
            'instruments'=>$project->getInstruments(),
            'admin'=>  $this->getUser()
        ));
    }

}
