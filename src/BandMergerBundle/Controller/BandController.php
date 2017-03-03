<?php

namespace BandMergerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BandMergerBundle\Entity\Instrument;
use BandMergerBundle\Entity\Band;
use BandMergerBundle\Entity\Project;
use BandMergerBundle\Entity\File;
use BandMergerBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use BandMergerBundle\Form\BandType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BandController extends Controller
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
     * @Route("/create")
     */
    public function createAction(Request $request)
    {
        $band = new Band();
        $form = $this->createForm(BandType::class,$band);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $band = $form->getData();
            $band->setAdmin($this->getUser());
            $band->addUser($this->getUser());
            $user = $this->getUser();
            $user->addBand($band);
            $em = $this->getDoctrine()->getManager();
            $em->persist($band);
            $em->flush();
            
            return $this->redirectToRoute("bandmerger_view_viewallbands",
                    [
                    ]);
        }
        return $this->render('BandMergerBundle:Band:create.html.twig', array(
            'form'=>$form->createView()
        ));
    }
    
    /**
     * @Route("/addUser/{id}")
     * @Method ("GET")
     */
    public function addUserAction(Band $band)
    {   
        $this->adminAccess($band);
        $this->checkAccess($band);
        return $this->render('BandMergerBundle:Band:add_user.html.twig', array(
            'band'=>$band
        ));
    }

    /**
     * @Route("/addUser/{id}")
     * @Method ("POST")
     */
    public function addUserSaveAction(Request $request,Band $band)
    {
        $this->adminAccess($band);
        $this->checkAccess($band);
        $username = $request->request->get('name');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('BandMergerBundle:User');
        $user = $repo->findOneBy(['username'=>$username]);
        if ($user)
        {
            if($band->getUsers()->contains($user))
            {
                return $this->render('BandMergerBundle:Band:add_user.html.twig', 
                array(
                'band'=>$band,
                'msg'=>'Username is already in band!!'
                ));
            }
            
            $band->addUser($user);
            $user->addBand($band);
            $em->flush();
            return $this->redirectToRoute("bandmerger_view_viewband",
                    [
                        'id' => $band->getId()
                    ]);
        }
        else
        {
            return $this->render('BandMergerBundle:Band:add_user.html.twig', 
                array(
                    'band'=>$band,
                    'msg'=>'Username not found!!'
                ));
        }
    }

    /**
     * @Route("/edit/{id}")
     */
    public function editAction( Request $request, Band $band)
    {
        $this->adminAccess($band);
        $this->checkAccess($band);
        $form = $this->createForm(BandType::class,$band);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            return $this->redirectToRoute("bandmerger_view_viewband",
                    [
                        'id' => $band->getId()
                    ]);
        }
        return $this->render('BandMergerBundle:Band:edit.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/delete/{id}")
     */
    public function deleteAction(Band $band)
    {
        $this->adminAccess($band);
        $this->checkAccess($band);
        $em = $this->getDoctrine()->getManager();
        $em->remove($band);
        $em->flush();
        return $this->redirectToRoute("bandmerger_view_viewallbands",
                    [
                    ]);
    }

    /**
     * @Route("/removeUser/{id}/{user}")
     */
    public function removeUserAction(Band $band, User $user)
    {
        if ($band->getAdmin()===$user)
        {
             return $this->render('BandMergerBundle:View:view_band.html.twig', array(
                'band'=>$band,
                'msg'=>'You cant remove admin from the band!'
            ));
        }
        $this->adminAccess($band);
        $this->checkAccess($band);
        $band->removeUser($user);
        $user->removeBand($band);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("bandmerger_view_viewband",
                    [
                        'id' => $band->getId()
                    ]);
    }
    
    
    /*
     *GOING TO BE USED IN NEXT VERSION!!!
     * 
     */
     
   
    /**
     * @Route("/inviteUser/{id}")
     */
    public function inviteUserAction(Band $band)
    {
        $this->adminAccess($band);
        $this->checkAccess($band);
        return $this->render('BandMergerBundle:Band:invite_user.html.twig', array(
            // ...
        ));
    }

}
