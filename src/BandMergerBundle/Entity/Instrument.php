<?php

namespace BandMergerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instrument
 *
 * @ORM\Table(name="instrument")
 * @ORM\Entity(repositoryClass="BandMergerBundle\Repository\InstrumentRepository")
 */
class Instrument
{    
    /**
     * @ORM\OneToMany(targetEntity="File", mappedBy="instrument")
     */
    private $files;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="instruments")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $project;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Instrument
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add filess
     *
     * @param \BandMergerBundle\Entity\File $files
     * @return Instrument
     */
    public function addFiless(\BandMergerBundle\Entity\File $files)
    {
        $this->files[] = $files;

        return $this;
    }

    /**
     * Remove files
     *
     * @param \BandMergerBundle\Entity\File $files
     */
    public function removeFiless(\BandMergerBundle\Entity\File $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set project
     *
     * @param \BandMergerBundle\Entity\Project $project
     * @return Instrument
     */
    public function setProject(\BandMergerBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \BandMergerBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add files
     *
     * @param \BandMergerBundle\Entity\File $files
     * @return Instrument
     */
    public function addFile(\BandMergerBundle\Entity\File $files)
    {
        $this->files[] = $files;

        return $this;
    }

    /**
     * Remove files
     *
     * @param \BandMergerBundle\Entity\File $files
     */
    public function removeFile(\BandMergerBundle\Entity\File $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Instrument
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
