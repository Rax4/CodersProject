<?php

namespace BandMergerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BandMergerBundle\Entity\Project;
use BandMergerBundle\Entity\Band;
use BandMergerBundle\Entity\Instrument;
use Symfony\Component\HttpFoundation\Request;
use BandMergerBundle\Form\ProjectType;

class ProjectController extends Controller
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
     * @Route("/projectCreate/{id}")
     */
    public function createAction(Request $request,Band $band)
    {
        $this->checkAccess($band);
        $project = new Project();
        $form = $this->createForm(ProjectType::class,$project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $project = $form->getData();
            $project->setBand($band);
            
            $general = new Instrument();
            $general->setName('General');
            $general->setProject($project);
            $general->setDescription($project->getDescription());
            $project->addInstrument($general);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->persist($general);
            $em->flush();
            
            return $this->redirectToRoute("bandmerger_view_viewband",
                    [
                        'id' => $band->getId()
                    ]);
        }
        return $this->render('BandMergerBundle:Project:create.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/project/edit/{id}")
     */
    public function editAction(Request $request,Project $project)
    {
        $this->checkAccess($project->getBand());
        $form = $this->createForm(ProjectType::class,$project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            return $this->redirectToRoute("bandmerger_view_viewband",
                    [
                        'id' => $project->getBand()->getId()
                    ]);
        }
        return $this->render('BandMergerBundle:Project:edit.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/project/delete/{id}")
     */
    public function deleteAction(Project $project)
    {
        $this->adminAccess($project->getBand());
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();
        
        return $this->redirectToRoute("bandmerger_view_viewband",
        [
            'id' => $project->getBand()->getId()
        ]);
    }

}
