<?php

namespace BandMergerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BandMergerBundle\Entity\Project;
use BandMergerBundle\Entity\Band;
use Symfony\Component\HttpFoundation\Request;
use BandMergerBundle\Entity\Instrument;
use BandMergerBundle\Form\InstrumentType;

class InstrumentController extends Controller
{
    private function checkAccess(Band $band)
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
    
    private function adminAccess(Band $band)
    {
        if (!($band->getAdmin()===$this->getUser()))
        {
            throw new \Exception("Acces Denied!");
        }
    }
    /**
     * @Route("instrument/create/{id}")
     */
    public function createAction(Request $request,Project $project)
    {
        $this->checkAccess($project->getBand());
        $instrument = new Instrument();
        $form = $this->createForm(InstrumentType::class,$instrument);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $instrument = $form->getData();
            $instrument->setProject($project); 
            $project->addInstrument($instrument);
            $em = $this->getDoctrine()->getManager();
            $em->persist($instrument);
            $em->persist($project);
            $em->flush();
            
            return $this->redirectToRoute("bandmerger_view_viewproject",
                    [
                        'id' => $project->getId()
                    ]);
        }
        return $this->render('BandMergerBundle:Instrument:create.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("instrument/edit/{id}")
     */
    public function editAction(Request $request, Instrument $instrument)
    {
        $this->checkAccess($instrument->getProject()->getBand());
        $form = $this->createForm(InstrumentType::class,$instrument);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $instrument = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            return $this->redirectToRoute("bandmerger_view_viewproject",
                    [
                        'id' => $instrument->getProject()->getId()
                    ]);
        }
        return $this->render('BandMergerBundle:Instrument:edit.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/remove/{id}")
     */
    public function removeAction(Instrument $instrument)
    {
        $this->adminAccess($instrument->getProject()->getBand());
        $em = $this->getDoctrine()->getManager();
        $em->remove($instrument);
        $em->flush();
        
        return $this->redirectToRoute("bandmerger_view_viewproject",
        [
            'id' => $instrument->getProject()->getId()
        ]);
    }

}
