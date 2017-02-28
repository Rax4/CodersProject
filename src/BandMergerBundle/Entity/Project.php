<?php

namespace BandMergerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="BandMergerBundle\Repository\ProjectRepository")
 */
class Project
{    
    
    /**
     * @ORM\OneToMany(targetEntity="Instrument", mappedBy="project")
     */
    private $instruments;
    
    /**
     * @ORM\ManyToOne(targetEntity="Band", inversedBy="projects")
     * @ORM\JoinColumn(name="band_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $band;
    
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


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
     * @return Project
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
     * Set description
     *
     * @param string $description
     * @return Project
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instruments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add instruments
     *
     * @param \BandMergerBundle\Entity\Instrument $instruments
     * @return Project
     */
    public function addInstrument(\BandMergerBundle\Entity\Instrument $instruments)
    {
        $this->instruments[] = $instruments;

        return $this;
    }

    /**
     * Remove instruments
     *
     * @param \BandMergerBundle\Entity\Instrument $instruments
     */
    public function removeInstrument(\BandMergerBundle\Entity\Instrument $instruments)
    {
        $this->instruments->removeElement($instruments);
    }

    /**
     * Get instruments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInstruments()
    {
        return $this->instruments;
    }

    /**
     * Set band
     *
     * @param \BandMergerBundle\Entity\Band $band
     * @return Project
     */
    public function setBand(\BandMergerBundle\Entity\Band $band = null)
    {
        $this->band = $band;

        return $this;
    }

    /**
     * Get band
     *
     * @return \BandMergerBundle\Entity\Band 
     */
    public function getBand()
    {
        return $this->band;
    }
}
