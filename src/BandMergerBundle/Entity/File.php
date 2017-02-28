<?php

namespace BandMergerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="BandMergerBundle\Repository\FileRepository")
 */
class File
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Instrument", inversedBy="files")
     * @ORM\JoinColumn(name="instrument_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $instrument;
    
    
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
     * @ORM\Column(name="src", type="string", length=255, unique=true)
     */
    private $src;
    
    /**
     * @var int
     *
     * @ORM\Column(name="accepted", type="integer")
     */
    private $accepted;


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
     * @return File
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
     * Set src
     *
     * @param string $src
     * @return File
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string 
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set accepted
     *
     * @param integer $accepted
     * @return File
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return integer 
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    public function setInstrument(\BandMergerBundle\Entity\Instrument $instrument = null)
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * Get instrument
     *
     * @return \BandMergerBundle\Entity\Instrument 
     */
    public function getInstrument()
    {
        return $this->instrument;
    }
}
