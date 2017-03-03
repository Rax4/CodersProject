<?php

namespace BandMergerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BandMergerBundle\Entity\File;
use BandMergerBundle\Entity\Instrument;
use Symfony\Component\HttpFoundation\Request;
use BandMergerBundle\Entity\Band;
use BandMergerBundle\Form\FileType;

class FileController extends Controller
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
     * @Route("file/create/{id}")
     */
    public function createAction(Request $request, Instrument $instrument)
    {
        
        $this->checkAccess($instrument->getProject()->getBand());
        $file = new File();
        $form = $this->createForm(FileType::class,$file);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $allowed =  array('ogg','mp3','wav','flac');
            $filename = $_FILES['bandmergerbundle_file']['name']['imageFile'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) ) {
                echo 'error';
            }
            if (!in_array($ext, $allowed))
            {
                return $this->render('BandMergerBundle:File:create.html.twig', array(
                    'form'=>$form->createView(),
                    'msg'=>'Wrong file extenion! Only files of ogg,mp3,wav,flac extensions are allowed!'
                ));
            }
            $file = $form->getData();
            $file->setInstrument($instrument);
            $file->setAccepted(0);
            
            $instrument->addFile($file);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();
            
            return $this->redirectToRoute("bandmerger_view_viewproject",
                    [
                        'id' => $instrument->getProject()->getId()
                    ]);
        }
        return $this->render('BandMergerBundle:File:create.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("file/edit/{id}")
     */
    public function editAction(File $file)
    {
        return $this->render('BandMergerBundle:File:edit.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("file/remove/{id}")
     */
    public function removeAction(File $file)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($file);
        $em->flush();
        return $this->redirectToRoute("bandmerger_view_viewproject",
                    [
                        'id' => $file->getInstrument()->getProject()->getId()
                    ]);
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
